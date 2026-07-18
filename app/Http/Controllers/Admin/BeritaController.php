<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        return view('admin.beritas.index', [
            'beritas' => Berita::with('kategori')->latest('tanggal')->paginate(10)
        ]);
    }

    public function scrapeUrl(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        $url = $request->url;

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
                'Cache-Control: max-age=0',
                'Referer: https://www.google.com/',
            ]);
            $html     = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (!$html || $httpCode >= 400) {
                $errorMsg = match(true) {
                    $httpCode === 403 => 'Website ini memblokir akses otomatis (403 Forbidden). Silakan isi konten berita secara manual.',
                    $httpCode === 404 => 'Halaman tidak ditemukan (404). Periksa kembali URL yang dimasukkan.',
                    $httpCode >= 500  => 'Server website tujuan sedang bermasalah (' . $httpCode . '). Coba lagi nanti.',
                    !$html            => 'Tidak dapat terhubung ke URL. Pastikan URL valid dan dapat diakses.',
                    default           => 'Gagal mengambil data (HTTP ' . $httpCode . ').',
                };
                return response()->json(['error' => $errorMsg], 422);
            }

            libxml_use_internal_errors(true);
            $doc = new \DOMDocument();
            $doc->loadHTML($html);
            $xpath = new \DOMXPath($doc);

            // 1. Ekstrak Judul
            $judul = '';
            $titleNode = $xpath->query('//meta[@property="og:title"]/@content | //title');
            if ($titleNode->length > 0) {
                $judul = trim($titleNode->item(0)->nodeValue);
            }

            // 2. Ekstrak Konten
            $konten = '';
            $descNode = $xpath->query('//meta[@property="og:description"]/@content | //meta[@name="description"]/@content');
            if ($descNode->length > 0) {
                $konten = trim($descNode->item(0)->nodeValue);
            }

            if (strlen($konten) < 50) {
                $paragraphs = [];
                $removeNodes = $xpath->query('//script | //style | //noscript | //nav | //header | //footer | //aside | //form');
                foreach ($removeNodes as $node) {
                    $node->parentNode->removeChild($node);
                }
                $bodyNodes = $xpath->query('//article//p | //main//p | //div[contains(@class,"post-content")]//p | //div[contains(@class,"entry-content")]//p | //div[contains(@class,"article-body")]//p | //div[contains(@class,"td-post-content")]//p | //div[contains(@id,"content")]//p');
                if ($bodyNodes->length === 0) {
                    $bodyNodes = $xpath->query('//p');
                }
                foreach ($bodyNodes as $p) {
                    $txt = trim($p->nodeValue);
                    if (strlen($txt) < 40) continue;
                    if (preg_match('/(_0x[a-f0-9]+|function\s*\(|var\s+\w|<\w+>|\{|\}|=>|===|!==|\$\(|innerHTML|document\.)/i', $txt)) continue;
                    $letterCount = preg_match_all('/[a-zA-Z\s]/u', $txt);
                    $totalCount  = mb_strlen($txt);
                    if ($totalCount > 0 && ($letterCount / $totalCount) < 0.5) continue;
                    $paragraphs[] = $txt;
                }
                if (count($paragraphs) > 0) {
                    $konten = implode("\n\n", $paragraphs);
                }
            }

            // 3. Ekstrak & Download Gambar
            $gambarUrl = '';
            $imageNode = $xpath->query('//meta[@property="og:image"]/@content | //meta[@name="twitter:image"]/@content');
            if ($imageNode->length > 0) {
                $gambarUrl = trim($imageNode->item(0)->nodeValue);
            }

            $localImagePath = null;
            if (!empty($gambarUrl)) {
                $imageResponse = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                    ->get($gambarUrl);
                if ($imageResponse->successful()) {
                    $filename = 'beritas/' . md5($gambarUrl) . '.jpg';
                    Storage::disk('public')->put($filename, $imageResponse->body());
                    $localImagePath = asset('storage/' . $filename);
                }
            }

            return response()->json([
                'success'    => true,
                'judul'      => $judul,
                'konten'     => $konten,
                'gambar_url' => $localImagePath,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    private function scrapeImageFromUrl(string $url): ?string
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $html = curl_exec($ch);
            curl_close($ch);

            if (!$html) return null;

            libxml_use_internal_errors(true);
            $doc = new \DOMDocument();
            $doc->loadHTML($html);
            $xpath = new \DOMXPath($doc);

            $nodes = $xpath->query('//meta[@property="og:image"]/@content | //meta[@name="twitter:image"]/@content');
            if ($nodes->length > 0) {
                $imageUrl = $nodes->item(0)->nodeValue;
                $imageResponse = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                    ->get($imageUrl);
                if ($imageResponse->successful()) {
                    $filename = 'beritas/' . md5($imageUrl) . '.jpg';
                    Storage::disk('public')->put($filename, $imageResponse->body());
                    return $filename;
                }
            }
        } catch (\Exception $e) {
            // Fail gracefully
        }
        return null;
    }

    public function create()
    {
        return view('admin.beritas.form', [
            'berita'    => null,
            'kategoris' => Kategori::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'konten'      => 'required|string',
            'tanggal'     => 'required|date',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'gambar'      => 'nullable|image|max:5120',
            'gambar_url'  => 'nullable|url',
            'link'        => 'nullable|url',
        ]);

        $data = $request->only('judul', 'konten', 'tanggal', 'kategori_id', 'link');
        $data['slug']  = Str::slug($request->judul) . '-' . time();
        $data['aktif'] = $request->boolean('aktif', true);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('beritas', 'public');
        } elseif ($request->filled('gambar_url')) {
            $imgRes = Http::timeout(15)->withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($request->gambar_url);
            if ($imgRes->successful()) {
                $filename = 'beritas/' . md5($request->gambar_url) . '.jpg';
                Storage::disk('public')->put($filename, $imgRes->body());
                $data['gambar'] = $filename;
            }
        } elseif ($request->filled('link')) {
            $scraped = $this->scrapeImageFromUrl($request->link);
            if ($scraped) $data['gambar'] = $scraped;
        }

        Berita::create($data);
        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.beritas.form', [
            'berita'    => $berita,
            'kategoris' => Kategori::all()
        ]);
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'konten'      => 'required|string',
            'tanggal'     => 'required|date',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'gambar'      => 'nullable|image|max:5120',
            'gambar_url'  => 'nullable|url',
            'link'        => 'nullable|url',
        ]);

        $data = $request->only('judul', 'konten', 'tanggal', 'kategori_id', 'link');
        $data['aktif'] = $request->boolean('aktif');

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
            $data['gambar'] = $request->file('gambar')->store('beritas', 'public');
        } elseif ($request->filled('gambar_url')) {
            $imgRes = Http::timeout(15)->withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($request->gambar_url);
            if ($imgRes->successful()) {
                if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
                $filename = 'beritas/' . md5($request->gambar_url) . '.jpg';
                Storage::disk('public')->put($filename, $imgRes->body());
                $data['gambar'] = $filename;
            }
        } elseif ($request->filled('link') && $request->link !== $berita->link) {
            $scraped = $this->scrapeImageFromUrl($request->link);
            if ($scraped) {
                if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
                $data['gambar'] = $scraped;
            }
        }

        $berita->update($data);
        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
        $berita->delete();
        return back()->with('success', 'Berita berhasil dihapus.');
    }

    public function storeBulk(Request $request)
    {
        $request->validate([
            'beritas'              => 'required|array|min:1|max:3',
            'beritas.*.judul'      => 'required|string|max:255',
            'beritas.*.konten'     => 'required|string',
            'beritas.*.tanggal'    => 'required|date',
            'beritas.*.kategori_id' => 'nullable|exists:kategoris,id',
            'beritas.*.link'       => 'nullable|url',
            'beritas.*.gambar_url' => 'nullable|url',
        ]);

        $count = 0;
        foreach ($request->beritas as $index => $item) {
            $data = [
                'judul'       => $item['judul'],
                'slug'        => Str::slug($item['judul']) . '-' . time() . '-' . uniqid(),
                'konten'      => $item['konten'],
                'tanggal'     => $item['tanggal'],
                'kategori_id' => $item['kategori_id'] ?? null,
                'link'        => $item['link'] ?? null,
                'aktif'       => isset($item['aktif']) ? (bool)$item['aktif'] : true,
            ];

            if (!empty($item['gambar_url'])) {
                try {
                    $imgRes = Http::timeout(15)->withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($item['gambar_url']);
                    if ($imgRes->successful()) {
                        $filename = 'beritas/' . md5($item['gambar_url'] . time()) . '.jpg';
                        Storage::disk('public')->put($filename, $imgRes->body());
                        $data['gambar'] = $filename;
                    }
                } catch (\Exception $e) {
                    // Fail gracefully
                }
            } elseif (!empty($item['link'])) {
                $scraped = $this->scrapeImageFromUrl($item['link']);
                if ($scraped) $data['gambar'] = $scraped;
            }

            Berita::create($data);
            $count++;
        }

        return redirect()->route('admin.beritas.index')->with('success', "$count Berita berhasil ditambahkan secara massal.");
    }
}

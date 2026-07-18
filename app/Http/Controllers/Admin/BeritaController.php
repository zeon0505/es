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
            'beritas' => Berita::with('kategori')->latest('tanggal')->get()
        ]);
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
        ]);

        $data = $request->only('judul', 'konten', 'tanggal', 'kategori_id');
        $data['slug']  = Str::slug($request->judul) . '-' . time();
        $data['aktif'] = $request->boolean('aktif', true);

        if ($request->hasFile('gambar')) {
            // Upload manual dari komputer
            $data['gambar'] = $request->file('gambar')->store('beritas', 'public');
        } elseif ($request->filled('gambar_scraped')) {
            // Gambar hasil scrape dari URL (sudah tersimpan di storage)
            $data['gambar'] = $request->input('gambar_scraped');
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
        ]);

        $data = $request->only('judul', 'konten', 'tanggal', 'kategori_id');
        $data['aktif'] = $request->boolean('aktif');

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
            $data['gambar'] = $request->file('gambar')->store('beritas', 'public');
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

    public function scrapeUrl(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120 Safari/537.36',
                'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            ])->timeout(20)->get($request->url);

            if (!$response->successful()) {
                return response()->json(['error' => 'Halaman tidak dapat diakses (HTTP ' . $response->status() . ')'], 422);
            }

            $html = $response->body();
            $dom  = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);

            // ── Judul ──
            $judul = '';
            $ogTitle = $xpath->query('//meta[@property="og:title"]/@content');
            if ($ogTitle->length > 0) {
                $judul = trim($ogTitle->item(0)->nodeValue);
            }
            if (!$judul) {
                $h1 = $xpath->query('//h1[contains(@class,"entry-title") or contains(@class,"post-title") or contains(@class,"title")]');
                if ($h1->length > 0) $judul = trim($h1->item(0)->textContent);
            }
            if (!$judul) {
                $h1 = $xpath->query('//h1');
                if ($h1->length > 0) $judul = trim($h1->item(0)->textContent);
            }

            // ── Tanggal ──
            $tanggal = date('Y-m-d');
            $timeNode = $xpath->query('//time[@datetime]/@datetime | //meta[@property="article:published_time"]/@content');
            if ($timeNode->length > 0) {
                $raw = $timeNode->item(0)->nodeValue;
                $parsed = strtotime($raw);
                if ($parsed) $tanggal = date('Y-m-d', $parsed);
            }

            // ── Konten ──
            $konten = '';
            $contentSelectors = [
                '//div[contains(@class,"entry-content")]',
                '//div[contains(@class,"post-content")]',
                '//div[contains(@class,"article-content")]',
                '//article',
            ];
            foreach ($contentSelectors as $selector) {
                $nodes = $xpath->query($selector);
                if ($nodes->length > 0) {
                    foreach ($nodes->item(0)->childNodes as $child) {
                        if (in_array($child->nodeName, ['p', 'h2', 'h3', 'h4', 'li'])) {
                            $text = trim($child->textContent);
                            if ($text && strlen($text) > 10) {
                                $konten .= $text . "\n\n";
                            }
                        }
                    }
                    if ($konten) break;
                }
            }

            // ── Gambar (unduh ke storage) ──
            $gambarPath = null;
            $ogImage = $xpath->query('//meta[@property="og:image"]/@content');
            if ($ogImage->length > 0) {
                $imgUrl = $ogImage->item(0)->nodeValue;
                try {
                    $imgResponse = Http::withHeaders([
                        'User-Agent' => 'Mozilla/5.0',
                    ])->timeout(15)->get($imgUrl);

                    if ($imgResponse->successful()) {
                        $ext = pathinfo(parse_url($imgUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                        $ext = strtolower(explode('?', $ext)[0]);
                        if (!in_array($ext, ['jpg','jpeg','png','webp','gif'])) $ext = 'jpg';
                        $filename = 'beritas/scrape_' . Str::random(12) . '.' . $ext;
                        Storage::disk('public')->put($filename, $imgResponse->body());
                        $gambarPath = $filename;
                    }
                } catch (\Exception $e) {
                    // gambar gagal diunduh, lanjut tanpa gambar
                }
            }

            return response()->json([
                'judul'   => $judul,
                'konten'  => trim($konten),
                'tanggal' => $tanggal,
                'gambar'  => $gambarPath,
                'gambar_preview' => $gambarPath ? asset('storage/' . $gambarPath) : null,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil konten: ' . $e->getMessage()], 422);
        }
    }
}

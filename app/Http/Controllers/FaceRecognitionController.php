<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Slider;
use App\Models\UserFace;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaceRecognitionController extends Controller
{
    public function recognize(Request $request)
    {
        // Validasi input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil file gambar
        $file = $request->file('image');
        $filePath = $file->getPathname();

        // Kirim permintaan ke API Flask
        $client = new Client();
        $url = 'http://127.0.0.1:5000/recognize';

        try {
            $response = $client->request('POST', $url, [
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($filePath, 'r'),
                        'filename' => $file->getClientOriginalName(),
                    ],
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);

            // Tampilkan hasil ke view
            return view('result', [
                'recognized' => $responseBody['recognized'],
                'message' => $responseBody['message'],
                'name' => $responseBody['name'] ?? null,
            ]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghubungi API Flask.']);
        }
    }
    public function homeNew(Request $request) {
        $data = [
            'user' => Auth::user(),
            'slides' => Slider::all(),
            // fyadm
            'fyAdm' => Dashboard::where('category', Dashboard::FYADM)->value('foto'),
            // fybody
            'fyBody' => Dashboard::where('category', Dashboard::FYBODY)->value('foto'),
            // bodymaps
            'bodyMaps' => Dashboard::where('category', Dashboard::BODYMAPS)->value('foto'),
            // structure
            'structure' => Dashboard::where('category', Dashboard::STRUCTURE)->value('foto'),
            
        ];
        $name = $request->query('name', 'Pengguna');

        return view('home',$data, compact('name'));
    }

    public function getUserFaces(Request $request)
    {
        $userFaces = UserFace::all(); // Ambil semua data wajah
        return response()->json($userFaces);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\CircleDt;
use App\Models\Comment;
use App\Models\CommentCbi;
use App\Models\CommentCbi2;
use App\Models\CommentCbi3;
use App\Models\CommentDt;
use App\Models\CommentDt2;
use App\Models\CommentDt3;
use App\Models\CommentCbi4;
use App\Models\CommentCbi5;
use App\Models\CommentCbi6;
use App\Models\CommentCbi7;
use App\Models\CommentCbi8;
use App\Models\CommentCbi9;
use App\Models\CommentDt4;
use App\Models\CommentDt5;
use App\Models\CommentDt6;
use App\Models\CommentDt7;
use App\Models\CommentDt8;
use App\Models\CommentDt9;
use App\Models\CommentQcc2;
use App\Models\CommentQcc3;
use App\Models\CommentQcc4;
use App\Models\CommentQcc5;
use App\Models\CommentQcc6;
use App\Models\CommentQcc7;
use App\Models\CommentQcc8;
use App\Models\CommentQcc9;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
    //-------approve with comment qcc 1
    public function approveComment(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_qcc_1,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentQcc8::where('circle_id', $validatedData['circle_id'])->exists();
                        
                        if ($existingNotulen) {
                            throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                        }
    
            // Buat objek Comment baru
            $comment = new Comment();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = Circle::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l1 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment qcc 2
    public function approveComment2(Request $request)
    {
        try {

            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_qcc_2,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentQcc8::where('circle_id', $validatedData['circle_id'])->exists();
                    
                    if ($existingNotulen) {
                        throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                    }
    
            // Buat objek Comment baru
            $comment = new CommentQcc2();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = Circle::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l2 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
         catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment qcc 3
    public function approveComment3(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_qcc_3,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentQcc8::where('circle_id', $validatedData['circle_id'])->exists();
                    
                    if ($existingNotulen) {
                        throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                    }
    
            // Buat objek Comment baru
            $comment = new CommentQcc3();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = Circle::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l3 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment qcc 4
    public function approveComment4(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_qcc_4,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentQcc8::where('circle_id', $validatedData['circle_id'])->exists();
                    
                    if ($existingNotulen) {
                        throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                    }
    
            // Buat objek Comment baru
            $comment = new CommentQcc4();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = Circle::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l4 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment qcc 5
    public function approveComment5(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_qcc_5,id',
                'comment' => 'required|string',
            ]);
    
             $existingNotulen = CommentQcc8::where('circle_id', $validatedData['circle_id'])->exists();
                    
                    if ($existingNotulen) {
                        throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                    }
    
            // Buat objek Comment baru
            $comment = new CommentQcc5();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = Circle::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l5 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment qcc 6
    public function approveComment6(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_qcc_6,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentQcc8::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
        
    
            // Buat objek Comment baru
            $comment = new CommentQcc6();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = Circle::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l6 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment qcc 7
    public function approveComment7(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_qcc_7,id',
                'comment' => 'required|string',
            ]);
    
             $existingNotulen = CommentQcc8::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
        
    
            // Buat objek Comment baru
            $comment = new CommentQcc7();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = Circle::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l7 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment qcc 8
    public function approveComment8(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_qcc_8,id',
                'comment' => 'required|string',
            ]);
            $existingNotulen = CommentQcc8::where('circle_id', $validatedData['circle_id'])->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
            }
    
            // Buat objek Comment baru
            $comment = new CommentQcc8();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = Circle::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l8 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment qcc 9
    public function approveComment9(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_qcc_9,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentQcc8::where('circle_id', $validatedData['circle_id'])->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
            }
    
            // Buat objek Comment baru
            $comment = new CommentQcc9();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = Circle::find($validatedData['circle_id']);
            if ($circle) {
                $circle->nqi = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }

    //-------approve with comment dt 1
    public function approveCommentDt(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_dt_1,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentDt::where('circle_id', $validatedData['circle_id'])->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
            }
    
            // Buat objek Comment baru
            $comment = new CommentDt();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l1 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment dt 2
    public function approveCommentDt2(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_dt_2,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentDt2::where('circle_id', $validatedData['circle_id'])->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
            }
            
            // Buat objek Comment baru
            $comment = new CommentDt2();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
            
            // Simpan objek Comment ke dalam database
            $comment->save();
            
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l2 = 2;
                $circle->save();
            }
            
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment dt 3
    public function approveCommentDt3(Request $request)
    {
        try {

            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_dt_3,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentDt3::where('circle_id', $validatedData['circle_id'])->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
            }
            
            // Buat objek Comment baru
            $comment = new CommentDt3();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
            
            // Simpan objek Comment ke dalam database
            $comment->save();
            
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l3 = 2;
                $circle->save();
            }
            
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment dt 3
    public function approveCommentDt4(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_dt_4,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentDt4::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentDt4();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l4 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 5
    public function approveCommentDt5(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_dt_5,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentDt5::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentDt5();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l5 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 6
    public function approveCommentDt6(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_dt_6,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentDt6::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentDt6();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l6 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 7
    public function approveCommentDt7(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_dt_7,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentDt7::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentDt7();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l7 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 8
    public function approveCommentDt8(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_dt_8,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentDt8::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentDt8();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l8 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 9
    public function approveCommentDt9(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_dt_9,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentDt9::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentDt9();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->nqi = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }

    //-------approve with comment dt 1
    public function approveCommentCbi(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_cbi_1,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentCbi::where('circle_id', $validatedData['circle_id'])->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
            }
    
            // Buat objek Comment baru
            $comment = new CommentCbi();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l1 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment dt 2
    public function approveCommentCbi2(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_cbi_2,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentCbi2::where('circle_id', $validatedData['circle_id'])->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
            }
            
            // Buat objek Comment baru
            $comment = new CommentCbi2();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
            
            // Simpan objek Comment ke dalam database
            $comment->save();
            
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l2 = 2;
                $circle->save();
            }
            
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment dt 3
    public function approveCommentCbi3(Request $request)
    {
        try {

            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_cbi_3,id',
                'comment' => 'required|string',
            ]);

            $existingNotulen = CommentCbi3::where('circle_id', $validatedData['circle_id'])->exists();
            
            if ($existingNotulen) {
                throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
            }
            
            // Buat objek Comment baru
            $comment = new CommentCbi3();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
            
            // Simpan objek Comment ke dalam database
            $comment->save();
            
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l3 = 2;
                $circle->save();
            }
            
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }
    }
    //-------approve with comment dt 3
    public function approveCommentCbi4(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_cbi_4,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentCbi4::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentCbi4();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l4 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 5
    public function approveCommentCbi5(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_cbi_5,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentCbi5::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentCbi5();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l5 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 6
    public function approveCommentCbi6(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_cbi_6,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentCbi6::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentCbi6();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l6 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 7
    public function approveCommentCbi7(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_cbi_7,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentCbi7::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentCbi7();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l7 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 8
    public function approveCommentCbi8(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_cbi_8,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentCbi8::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentCbi8();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->l8 = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
    //-------approve with comment dt 9
    public function approveCommentCbi9(Request $request)
    {
        try {
            // Validasi data yang diterima dari form
            $validatedData = $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'notulen_id' => 'required|exists:notulen_cbi_9,id',
                'comment' => 'required|string',
            ]);
    
            $existingNotulen = CommentCbi9::where('circle_id', $validatedData['circle_id'])->exists();
                
                if ($existingNotulen) {
                    throw new \Exception('Anda sudah melakukan comment, dan tidak dapat dilakukan lagi.');
                }
    
            // Buat objek Comment baru
            $comment = new CommentCbi9();
            $comment->circle_id = $validatedData['circle_id'];
            $comment->notulen_id = $validatedData['notulen_id'];
            $comment->comment = $validatedData['comment'];
    
            // Simpan objek Comment ke dalam database
            $comment->save();
    
            // Update nilai l1 pada tabel circle menjadi 2
            $circle = CircleDt::find($validatedData['circle_id']);
            if ($circle) {
                $circle->nqi = 2;
                $circle->save();
            }
    
            // Redirect pengguna ke halaman yang sesuai, misalnya halaman sebelumnya
            return redirect()->back()->with('success', 'Comment berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan comment. Error: ' . $e->getMessage());
        }

    }
}

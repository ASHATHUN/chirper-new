<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Illuminate\Http\Response; 
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    public function index(): Response 
    {
        //
        // return response('Hello, World!'); อันนี้คือการรันคำสั่งให้ยิงจากหลังบ้านขึ้นไปหน้าเว็บโดยตรง
        return Inertia::render('Chirps/Index', [
            //อันนี้คือการให้มันไปดึงจากไฟล์ Index (ฝั่งfrontend)
            // การทำงานเมื่อพิมพ์ URL ตัวนึง จะเริ่มจาก Routing->Controller->Index
            // where user id = ค่าที่ส่งเข้ามา เอาข้อมูล latest ดึงข้อมูลขึ้นมาโชว์ แค่บรรทัดนี้
            'chirps' => Chirp::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    public function store(Request $request): RedirectResponse
    {
        //
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            // ข้อความพิมพ์อักษรได้ 255 ตัว 
        ]);
 
        $request->user()->chirps()->create($validated);
        // create แล้วจะสร้างคอลัมน์database
 
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Chirp $chirp)
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        //การป้องกันข้อมูล
        Gate::authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
        // คำสั่งที่ใช้ในการแก้ไขข้อความมีบรรทัดเดียว คือบรรทัด 86 เอาข้อมูลที่ Validated เรียบร้อย มาแก้ไข
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Chirp $chirp)
    public function destroy(Chirp $chirp): RedirectResponse
    {
        //
        Gate::authorize('delete', $chirp);
 
        // คำสั่งที่ใช้ในการลบข้อความ
        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }
}

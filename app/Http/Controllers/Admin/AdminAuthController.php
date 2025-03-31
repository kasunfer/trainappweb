<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            Auth::login(Auth::user(), true);
            Log::info('auth',[Auth::user()]);
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        // $user->last_logout = now();
        $user->save();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // activity()
        //     ->causedBy($user)
        //     ->performedOn($user)
        //     ->withProperties(["attributes" => ['ip_address' => request()->ip()]])
        //     ->log('Logged Out');
        return redirect()->route('admin.login');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

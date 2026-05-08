<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Sale;
use App\Models\Activity;
use App\Models\User;

class DashboardController extends Controller
{
    public function management() 
    {
        $totalClientes = User::where('role', 'cliente')->count();
        $totalContactos = Contact::count();
        $totalVentas = Sale::count();

        $ventasPorEstado = Sale::selectRaw('status, COUNT(*) as total, SUM(amount) as monto')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $actividadesRecientes = Activity::with('contact.user')
            ->orderByDesc('occurred_at')
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'totalClientes',
            'totalContactos',
            'totalVentas',
            'ventasPorEstado',
            'actividadesRecientes'
        ));
    }
}

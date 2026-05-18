<?php

// Created by Lailatul Fitaliqoh (5026231229)

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Menampilkan Daftar Chat (List)
     * Mengambil pesan terakhir dari setiap toko.
     */
    public function index()
    {
        $userId = Auth::user()->id_user;

        // 2. Cari ID chat terakhir untuk setiap toko yang pernah berinteraksi
        // (Logika: Grouping berdasarkan id_store, ambil MAX id_chat)
        $latestChatIds = Chat::select(DB::raw('MAX(id_chat) as id_chat'))
            ->where('id_user', $userId)
            ->groupBy('id_store')
            ->pluck('id_chat');

        // 3. Ambil data lengkap dari ID chat tersebut + Data Tokonya
        $rawChats = Chat::whereIn('id_chat', $latestChatIds)
            ->with('store')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        $chats = $rawChats->map(function ($chat) {
            return [
                'store_id' => $chat->id_store,

                // Nama Toko
                'name' => $chat->store->name_store ?? 'Unknown Store',

                // Foto Toko
                'avatar' => $chat->store && $chat->store->photo
                                ? asset('images/stores/'.$chat->store->photo)
                                : 'https://placehold.co/100/F06A7D/white?text='.substr($chat->store->name_store ?? 'U', 0, 1),

                // Isi Pesan Terakhir
                'message' => $chat->message,

                // Format Waktu (Hari ini: Jam, Kemarin: Tanggal)
                'time' => Carbon::parse($chat->date)->isToday()
                                ? Carbon::parse($chat->time)->format('H:i')
                                : Carbon::parse($chat->date)->format('d/m'),

                // Unread (Sementara 0 karena belum ada kolom is_read di database)
                'unread' => 0,
            ];
        });

        return view('chat.chats', compact('chats'));
    }

    /**
     * Menampilkan Detail Chat (Room Percakapan)
     */
    public function show($storeId)
    {
        $userId = Auth::user()->id_user;

        // Memastikan toko ada
        $store = Store::findOrFail($storeId);

        // Ambil semua history chat user dengan toko ini dan urutan ASC
        $messages = Chat::where('id_user', $userId)
            ->where('id_store', $storeId)
            ->with(['product', 'orders'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return view('chat.chatdengantoko', compact('store', 'messages'));
    }

    /**
     * Memulai Chat dari Halaman Detail Produk (Product Inquiry)
     */
    public function chatWithProduct($productId)
    {
        $user = Auth::user();

        // 1. Cari data produk untuk tahu Toko mana pemiliknya
        $product = \App\Models\Product::findOrFail($productId);
        $storeId = $product->id_store;

        // 2. Cek Pesan Terakhir (Supaya tidak spam bubble produk yg sama)
        // Kita cek apakah pesan terakhir di room ini adalah produk yang sama?
        $lastChat = Chat::where('id_user', $user->id_user)
            ->where('id_store', $storeId)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->first();

        // Jika belum ada chat, atau chat terakhir bukan tentang produk ini
        // Maka kita buat bubble baru
        if (! $lastChat || $lastChat->id_product != $productId) {
            Chat::create([
                'id_user' => $user->id_user,
                'id_store' => $storeId,
                'id_product' => $productId,
                'message' => null,       // Pesan teks kosong, karena cuma kirim attachment produk
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i:s'),
                'sender_role' => 'user',
            ]);
        }

        // 3. Redirect langsung ke halaman detail chat toko tersebut
        return redirect()->route('chat.show', $storeId);
    }

    /**
     * Mengirim Pesan Baru
     */
    public function send(Request $request, $storeId)
    {
        // Validasi input
        $request->validate(['message' => 'required']);

        // Simpan ke database
        Chat::create([
            'id_user' => Auth::user()->id_user,
            'id_store' => $storeId,
            'message' => $request->message,
            'date' => now()->format('Y-m-d'),
            'time' => now()->format('H:i:s'),
            'sender_role' => 'user',
        ]);

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\request_pesanan;
use App\Http\Resources\resource_pesanan;
use App\Services\service_pesanan;
use Illuminate\Http\Request as HttpRequest;

class controller_pesanan extends Controller
{

    private service_pesanan $service;
    public function __construct(service_pesanan $service)
    {
        $this->service = $service;
    }

    public function getHistoryByEmail(string $id)
    {
        $pesanan = $this->service->readHistoryByEmail($id);

        return  resource_pesanan::collection($pesanan);
    }

    public function getAllHistoryPesanan()
    {
        $pesanan = $this->service->getAllHistoryPesanan();
        return  resource_pesanan::collection($pesanan);
    }

    public function getLatestPesanan($month)
    {
        $pesanan = $this->service->getLatestPesananId($month);
        return response()->json([
            "no_pesanan" => $pesanan
        ]);
    }

    public function generateNoNota($month)
    {
        $nota = $this->service->generateNoNota($month);
        return response()->json([
            "no_nota" => $nota
        ]);
    }

    public function PesanProduk(request_pesanan $request)
    {
        $pesananValidated = $request->validated();
        $this->service->PesanProduk($pesananValidated);
        return response()->json([
            "message" => "Pesanan berhasil dibuat"
        ]);
    }

    // Daftar Pesanan yang Perlu Input Jarak
    public function getPesananNeedInputJarak()
    {
        $pesanan = $this->service->getPesananNeedInputJarak();
        return  resource_pesanan::collection($pesanan);
    }

    // Input Jarak Pengiriman
    // public function inputJarak($pesananId, $alamatId)
    // {
    //     $this->service->inputJarak($pesananId, $alamatId);
    //     return response()->json([
    //         "message" => "Jarak updated successfully"
    //     ]);
    // }

    // Input Jarak Pengiriman
    public function updatePesanan(HttpRequest $request, $id)
    {
        $jarak = $request->input('jarak');
        $this->service->updatePesanan($id, $jarak);
        return response()->json(['message' => 'Pesanan updated successfully']);
    }
    
    // Daftar Pesanan yang Perlu Konfirmasi
    public function getPesananNeedConfirm()
    {
        $pesanan = $this->service->getPesananNeedConfirm();
        return  resource_pesanan::collection($pesanan);
    }


}

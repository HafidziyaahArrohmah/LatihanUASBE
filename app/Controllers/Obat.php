<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Obat extends ResourceController
{
    protected $modelName = 'App\\Models\\ObatModel';
    protected $format    = 'json';


    public function index()
    {
        $obat = $this->model->orderBy('id', 'DESC')->findAll();

        $data = [
            'status' => true,
            'message' => 'success',
            'data_obat' => $obat
        ];

        return $this->respond($data, 200);
    }

        public function show($id = null)
    {
        $data = [
            'message' => 'success',
            'obat_byid' => $this->model->find($id)
        ];

        if ($data['obat_byid'] == null) {
            return $this->failNotFound('Data obat tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function create()
    {
        $rules = $this->validate([
            'nama_obat' => 'required',
            'kategori' => 'required',
            'stok' => 'required',
            'harga' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->insert([
            'nama_obat' => esc($this->request->getVar('nama_obat')),
            'kategori' => esc($this->request->getVar('kategori')),
            'stok' => esc($this->request->getVar('stok')),
            'harga' => esc($this->request->getVar('harga')),
        ]);

        $response = [
            'messsage' => 'Data obat berhasil ditambahkan'
        ];

        return $this->respondCreated($response);
    }

    public function update($id_room = null)
    {
        $rules = $this->validate([
            'nama_obat' => 'required',
            'kategori' => 'required',
            'stok' => 'required',
            'harga' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->update($id_room, [
            'nama_obat' => esc($this->request->getVar('nama_obat')),
            'kategori' => esc($this->request->getVar('kategori')),
            'stok' => esc($this->request->getVar('stok')),
            'harga' => esc($this->request->getVar('harga')),
        ]);

        $response = [
            'messsage' => 'Data obat berhasil diubah'
        ];

        return $this->respond($response, 200);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);

        $response = [
            'messsage' => 'Data obat berhasil dihapus'
        ];

        return $this->respondDeleted($response);
    }
}

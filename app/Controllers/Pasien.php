<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Pasien extends ResourceController
{
    protected $modelName = 'App\\Models\\PasienModel';
    protected $format    = 'json';

    public function index()
    {
        $pasien = $this->model->orderBy('id', 'DESC')->findAll();

        $data = [
            'status' => true,
            'message' => 'success',
            'data_pasien' => $pasien
        ];

        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = [
            'message' => 'success',
            'pasien_byid' => $this->model->find($id)
        ];

        if ($data['pasien_byid'] == null) {
            return $this->failNotFound('Data pasien tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function create()
    {
        $rules = $this->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->insert([
            'nama' => esc($this->request->getVar('nama')),
            'alamat' => esc($this->request->getVar('alamat')),
            'tanggal_lahir' => esc($this->request->getVar('tanggal_lahir')),
            'jenis_kelamin' => esc($this->request->getVar('jenis_kelamin')),
        ]);

        $response = [
            'messsage' => 'Data pasien berhasil ditambahkan'
        ];

        return $this->respondCreated($response);
    }

    public function update($id_room = null)
    {
        $rules = $this->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->update($id_room, [
            'nama' => esc($this->request->getVar('nama')),
            'alamat' => esc($this->request->getVar('alamat')),
            'tanggal_lahir' => esc($this->request->getVar('tanggal_lahir')),
            'jenis_kelamin' => esc($this->request->getVar('jenis_kelamin')),
        ]);

        $response = [
            'messsage' => 'Data pasien berhasil diubah'
        ];

        return $this->respond($response, 200);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);

        $response = [
            'messsage' => 'Data pasien berhasil dihapus'
        ];

        return $this->respondDeleted($response);
    }
}

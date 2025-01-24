<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Mcustom;

class formController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Mcustom();
    }

    public function formKids()
    {
        $kondisi = "idpendkursus IN ('K00001', 'K00002', 'K00003', 'K00004')";
        $data['users'] = $this->model->getAllW("pendidikankursus", $kondisi);
        return view('form_kids', $data);
    }

    public function formCoding()
    {
        $data['idpendkursus'] = 'K00005';
        return view('form_coding', $data);
    }

    public function formAdult()
    {
        $kondisi = "idpendkursus IN ('K00006', 'K00007', 'K00008', 'K00009')";
        $data['users'] = $this->model->getAllW("pendidikankursus", $kondisi);
        return view('form_adult', $data);
    }

    public function submit()
    {
        $validation = \Config\Services::validation();

        // Identifikasi form berdasarkan input
        $formType = $this->request->getPost('form_type');

        if ($formType === 'kids') {
            $validation->setRules([
                'fullName' => 'required',
                'nickName' => 'required',
                'schoolName' => 'required',
                'classLevel' => 'required',
                'gender' => 'required',
                'curriculum' => 'required',
                'exp' => 'required',
                'diagnostic' => 'required',
                'info' => 'required',
                'domicile' => 'required',
                'email' => 'required|valid_email',
                'phone1' => 'required|numeric',
                'idpendkursus' => 'required',
                'payment' => 'uploaded[payment]|max_size[payment,10240]|ext_in[payment,jpg,jpeg,png,pdf]',
            ]);
        } elseif ($formType === 'coding') {
            $validation->setRules([
                'email' => 'required|valid_email',
                'fullName' => 'required',
                'nickName' => 'required',
                'domicile' => 'required',
                'schoolName' => 'required',
                'class_options' => 'required',
                'phone1' => 'required|numeric',
                'computer' => 'required',
                'software' => 'required',
                'exp' => 'required',
                'info' => 'required',
                'hope' => 'required',
                'date' => 'required',
                'payment' => 'uploaded[payment]|max_size[payment,10240]|ext_in[payment,jpg,jpeg,png,pdf]',
            ]);
        } elseif ($formType === 'adult') {
            $validation->setRules([
                'fullName' => 'required',
                'nickName' => 'required',
                'domicile' => 'required',
                'gender' => 'required',
                'activities' => 'required',
                'email' => 'required|valid_email',
                'info' => 'required',
                'class_options' => 'required',
                'idpendkursus' => 'required',
                'purpose' => 'required',
            ]);
        } else {
            return redirect()->to('/')->withInput()->with('message', 'Form tidak dikenali.');
        }

        if (!$validation->withRequest($this->request)->run()) {
            if ($formType === 'kids') {
                return redirect()->to('/')->withInput()->with('message', 'Validasi gagal: ' . implode(', ', $validation->getErrors()));
            } elseif ($formType === 'coding') {
                return redirect()->to('/coding')->withInput()->with('message', 'Validasi gagal: ' . implode(', ', $validation->getErrors()));
            } elseif ($formType === 'adult') {
                return redirect()->to('/adult')->withInput()->with('message', 'Validasi gagal: ' . implode(', ', $validation->getErrors()));
            }
        }

        $file = $this->request->getFile('payment');
        $fileName = null;

        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $filePath = 'uploads/' . $fileName;

            if (!$file->move(WRITEPATH . 'uploads', $fileName)) {
                if ($formType === 'kids') {
                    return redirect()->to('/')->withInput()->with('message', 'File gagal diunggah.');
                } elseif ($formType === 'coding') {
                    return redirect()->to('/coding')->withInput()->with('message', 'File gagal diunggah.');
                } elseif ($formType === 'adult') {
                    return redirect()->to('/adult')->withInput()->with('message', 'File gagal diunggah.');
                }
            }
        }

        $data = array(
            'idcalon' => $this->model->autokode("C", "idcalon", "form_calon", 2, 10),
            'idpendkursus' => $this->request->getPost('idpendkursus'),
            'fullName' => $this->request->getPost('fullName'),
            'nickName' => $this->request->getPost('nickName'),
            'schoolName' => $this->request->getPost('schoolName'),
            'classLevel' => $this->request->getPost('classLevel'),
            'gender' => $this->request->getPost('gender'),
            'activities' => $this->request->getPost('activities'),
            'otherActivities' => $this->request->getPost('otherActivities'),
            'curriculum' => $this->request->getPost('curriculum'),
            'exp' => $this->request->getPost('exp'),
            'diagnostic' => $this->request->getPost('diagnostic'),
            'info' => $this->request->getPost('info'),
            'domicile' => $this->request->getPost('domicile'),
            'email' => $this->request->getPost('email'),
            'phone1' => $this->request->getPost('phone1'),
            'phone2' => $this->request->getPost('phone2'),
            'class_options' => $this->request->getPost('class_options'),
            'officeApp' => $this->request->getPost('officeApp'),
            'editing' => $this->request->getPost('editing'),
            'custom' => $this->request->getPost('custom'),
            'purpose' => $this->request->getPost('puropse'),
            'recom' => $this->request->getPost('recom'),
            'placement' => $this->request->getPost('placement'),
            'otherDetail' => $this->request->getPost('otherDetail'),
            'computer' => $this->request->getPost('computer'),
            'software' => $this->request->getPost('software'),
            'hope' => $this->request->getPost('hope'),
            'gadget' => is_array($this->request->getPost('gadget'))
                ? implode(',', $this->request->getPost('gadget'))
                : $this->request->getPost('gadget'),
            'date' => $this->request->getPost('date'),
            'payment' => $fileName,
        );

        $simpan = $this->model->add("form_calon", $data);
        if ($simpan == 1) {
            if ($formType === 'kids') {
                return redirect()->to('/')->with('message', 'Form tersimpan.');
            } elseif ($formType === 'coding') {
                return redirect()->to('/coding')->with('message', 'Form tersimpan.');
            } elseif ($formType === 'adult') {
                echo "<script>
                alert('Form berhasil disimpan.');
                window.location.href = 'https://docs.google.com/forms/d/e/1FAIpQLSedKzdkEBDLjrDkgWs4d74I0aVLlcNyQRU-EIEARda-kP0XBA/viewform';
              </script>";
                exit;
            }
        } else {
            if ($formType === 'kids') {
                return redirect()->to('/')->with('message', 'Form gagal tersimpan.');
            } elseif ($formType === 'coding') {
                return redirect()->to('/coding')->with('message', 'Form gagal tersimpan.');
            } elseif ($formType === 'adult') {
                return redirect()->to('/adult')->with('message', 'Form gagal tersimpan.');
            }
        }
    }
}
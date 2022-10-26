<?php

namespace App\Controllers;

use Config\Services;
use Exception;
use Dompdf\Dompdf;
use Dompdf\Options;

class Home extends BaseController
{
    protected $data;
    protected $session;
    protected $uri;
    protected $userModel;
    protected $divisiModel;
    protected $shiftModel;
    protected $tepungModel;
    protected $mixingModel;
    protected $dryingModel;
    protected $laporanModel;

    protected $db;

    public function __construct()
    {
        $this->data['appname'] = 'Production Report'; 
        $this->session = Services::session();
        $this->uri = Services::uri();
        $this->userModel = new \App\Models\UserModel();
        $this->divisiModel = new \App\Models\DivisiModel();
        $this->shiftModel = new \App\Models\ShiftModel();
        $this->tepungModel = new \App\Models\TepungModel();
        $this->mixingModel = new \App\Models\MixingModel();
        $this->dryingModel = new \App\Models\DryingModel();
        $this->laporanModel = new \App\Models\LaporanModel();

        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            return view('layouts/home.php', $this->data);
        }else{
            return redirect()->to('login');
        }
    }

    public function org()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            return view('layouts/home-org.php', $this->data);
        }else{
            return redirect()->to('login');
        }
    }

    public function login()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');
            if($sesi['divisi']==1){
                return redirect()->to('');
            }else{
                return redirect()->to('laporan');
            }
        }else{
            $this->data['msg'] = $this->session->getFlashdata('msg');
            return view('layouts/login.php', $this->data);
        }
    }

    public function loginProcess()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $cek = $this->userModel->where(['username'=>$username, 'password'=>$password])->find();

        if(count($cek)>0){
            $this->session->set('userdata', $cek[0]);
            if($cek[0]['divisi']==1){
                return redirect()->to('');
            }else{
                return redirect()->to('laporan');
            }
        }else{
            $this->session->setFlashdata('msg', 'Username atau Password salah.');
            return redirect()->to('login');
        }
    }

    public function logoutProcess()
    {
      $this->session->remove('userdata');
      $this->session->setFlashdata('msg', $this->session->getFlashdata('msg'));
      return redirect()->to('login');
    }

    public function laporan()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['f_divisi'] = $this->request->getPost('f_divisi');
            if(!empty($this->data['f_divisi'])){
                $this->data['f_nama_divisi'] = url_title($this->divisiModel->where('id_divisi', $this->data['f_divisi'])->find()[0]['nama_divisi'], '', true);
            }else{
                $this->data['f_nama_divisi'] = '';
            }
            $this->data['f_bulan'] = $this->request->getPost('f_bulan');
            $this->data['f_tahun'] = !empty($this->request->getPost('f_tahun'))? $this->request->getPost('f_tahun'): date("Y");
            $this->data['flagfilter'] = (!empty($this->data['f_divisi']) || !empty($this->data['f_bulan']) || !empty($this->data['f_tahun']))? true: false;
             
            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');

            $this->data['shift'] = $this->shiftModel->findAll();
            $this->data['tepung'] = $this->tepungModel->findAll();
            $this->data['roti'] = $this->mixingModel->findAll();
            $this->data['label'] = $this->dryingModel->findAll();

            $this->data['divisis'] = $this->divisiModel->findAll();
            $this->data['bulans'] = $this->db->table('laporan')->select('MONTH(tanggal) bulan')->groupBy('bulan')->get()->getResultArray();
            $this->data['tahuns'] = $this->db->table('laporan')->select('YEAR(tanggal) tahun')->groupBy('tahun')->get()->getResultArray();

            if($this->data['id_divisi']==1){
                $this->data['laporan'] = $this->laporanModel;
                if(!empty($this->data['f_divisi'])){
                    $this->data['laporan'] = $this->data['laporan']->where('id_divisi', $this->data['f_divisi']);
                }
                if(!empty($this->data['f_bulan'])){
                    $this->data['laporan'] = $this->data['laporan']->where('MONTH(tanggal)', $this->data['f_bulan']);
                }
                if(!empty($this->data['f_tahun'])){
                    $this->data['laporan'] = $this->data['laporan']->where('YEAR(tanggal)', $this->data['f_tahun']);
                }
                $this->data['laporan'] = $this->data['laporan']->orderBy('tanggal', 'desc')->orderBy('nama_shift', 'asc')->orderBy('id_divisi', 'asc')->findAll();
            }else{
                $this->data['laporan'] = $this->laporanModel->where(['id_divisi'=>$this->data['id_divisi'], 'YEAR(tanggal)'=>date("Y")])->orderBy('tanggal', 'desc')->orderBy('nama_shift', 'asc')->orderBy('id_divisi', 'asc')->find();
            }

            return view('layouts/laporan.php', $this->data);
        }else{
            return redirect()->to('login');
        }
    }

    public function laporanAksiAyaktepung()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $user = $sesi['nama'];
            $id_divisi = $sesi['divisi'];
            $divisi = $this->divisiModel->where('id_divisi', $id_divisi)->find()[0]['nama_divisi'];

            $tanggal = $this->request->getPost('tanggal');
            $nama_shift = $this->request->getPost('nama_shift');
            $produk = $this->request->getPost('produk');
            $qty = $this->request->getPost('qty').' SAK';
            $qty_stok = $this->request->getPost('qty_stok')[0].' Box - 10Kg;'.$this->request->getPost('qty_stok')[1].' Box - 25Kg';
            $qty_limbah = ((float) $this->request->getPost('qty_limbah')).' Gram';
            $operator = $this->request->getPost('operator');
            $kendala = $this->request->getPost('kendala');

            $formData = [
                'tanggal' => $tanggal,
                'nama_shift' => $nama_shift,
                'produk' => $produk,
                'qty' => $qty,
                'qty_stok' => $qty_stok,
                'qty_limbah' => $qty_limbah,
                'operator' => $operator,
                'kendala' => $kendala,
                'user' => $user,
                'id_divisi' => $id_divisi,
                'divisi' => $divisi
            ];

            $this->laporanModel->insert($formData);

            $this->session->setFlashdata('msg', 'Laporan Berhasil.');
            return redirect()->to('laporan');
        }else{
            return redirect()->to('login');
        }
    }

    public function laporanAksiMixing()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $user = $sesi['nama'];
            $id_divisi = $sesi['divisi'];
            $divisi = $this->divisiModel->where('id_divisi', $id_divisi)->find()[0]['nama_divisi'];

            $tanggal = $this->request->getPost('tanggal');
            $nama_shift = $this->request->getPost('nama_shift');
            $no_planprod = $this->request->getPost('no_planprod');
            $jenis_oven = $this->request->getPost('jenis_oven');
            $produk = $this->request->getPost('produk');
            $qty = $this->request->getPost('qty').' Batch';
            $operator = $this->request->getPost('operator');
            $kendala = $this->request->getPost('kendala');

            $formData = [
                'tanggal' => $tanggal,
                'nama_shift' => $nama_shift,
                'no_planprod' => $no_planprod,
                'jenis_oven' => $jenis_oven,
                'produk' => $produk,
                'qty' => $qty,
                'operator' => $operator,
                'kendala' => $kendala,
                'user' => $user,
                'id_divisi' => $id_divisi,
                'divisi' => $divisi
            ];

            $this->laporanModel->insert($formData);

            $this->session->setFlashdata('msg', 'Laporan Berhasil.');
            return redirect()->to('laporan');
        }else{
            return redirect()->to('login');
        }
    }

    public function laporanAksiDrying()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $user = $sesi['nama'];
            $id_divisi = $sesi['divisi'];
            $divisi = $this->divisiModel->where('id_divisi', $id_divisi)->find()[0]['nama_divisi'];

            $tanggal = $this->request->getPost('tanggal');
            $nama_shift = $this->request->getPost('nama_shift');
            $no_planprod = $this->request->getPost('no_planprod');
            $no_mesin = $this->request->getPost('no_mesin');
            $jenis_oven = $this->request->getPost('jenis_oven');
            $produk = $this->request->getPost('produk')[0].' - '.$this->request->getPost('produk')[1];
            $operator = $this->request->getPost('operator');
            $kendala = $this->request->getPost('kendala');

            $formData = [
                'tanggal' => $tanggal,
                'nama_shift' => $nama_shift,
                'no_planprod' => $no_planprod,
                'no_mesin' => $no_mesin,
                'jenis_oven' => $jenis_oven,
                'produk' => $produk,
                'operator' => $operator,
                'kendala' => $kendala,
                'user' => $user,
                'id_divisi' => $id_divisi,
                'divisi' => $divisi
            ];

            $this->laporanModel->insert($formData);

            $this->session->setFlashdata('msg', 'Laporan Berhasil.');
            return redirect()->to('laporan');
        }else{
            return redirect()->to('login');
        }
    }

    public function laporanLihat($id)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');

            $id = explode(';', hex2bin($id))[1];
            $this->data['laporan'] = $this->laporanModel->where('id_laporan', $id)->find()[0];
            $this->data['laporan_id_divisi'] = $this->data['laporan']['id_divisi'];
            $this->data['laporan_divisi'] = $this->data['laporan']['divisi'];
            
            $this->data['title'] = "Laporan";
            $this->data['flaghapus'] = false;
            
            return view('layouts/laporan-lihat.php', $this->data);
        }else{
            return redirect()->to('login');
        }
    }

    public function laporanDel($id)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');

            $id = explode(';', hex2bin($id))[1];
            $this->data['laporan'] = $this->laporanModel->where('id_laporan', $id)->find()[0];
            $this->data['laporan_id_divisi'] = $this->data['laporan']['id_divisi'];
            $this->data['laporan_divisi'] = $this->data['laporan']['divisi'];
            
            $this->data['title'] = "Hapus Laporan?";
            $this->data['flaghapus'] = true;
            
            return view('layouts/laporan-lihat.php', $this->data);
        }else{
            return redirect()->to('login');
        }
    }
    public function laporanDelAct()
    {
        if($this->session->has('userdata')){
            $segment1 = $this->uri->getSegment(1);
            
            $id_laporan = $this->request->getPost('id_laporan');

            $this->laporanModel->delete($id_laporan);
            $this->session->setFlashdata("msg", "Hapus Laporan Berhasil.");
            return redirect()->to($segment1);

        }else{
            return redirect()->to('login');
        }
    }

    public function laporanPrint($filter, $filename){
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
                
            if($sesi['divisi']==1){
                $filter = hex2bin($filter);
                $f_divisi = explode(";", $filter)[0];
                $f_bulan = explode(";", $filter)[1];
                $f_tahun = explode(";", $filter)[2];
                
                $laporan = $this->laporanModel;
                if(!empty($f_divisi)){
                    $laporan = $laporan->where('id_divisi', $f_divisi);
                }
                if(!empty($f_bulan)){
                    $laporan = $laporan->where('MONTH(tanggal)', $f_bulan);
                }
                if(!empty($f_tahun)){
                    $laporan = $laporan->where('YEAR(tanggal)', $f_tahun);
                }
                $laporan = $laporan->orderBy('tanggal', 'desc')->orderBy('nama_shift', 'asc')->orderBy('id_divisi', 'asc')->findAll();
                $f_nama_divisi = !empty($f_divisi)? $laporan[0]['divisi']: '';
                $f_nama_bulan = !empty($f_bulan)? date('F', strtotime('9999'.$f_bulan.'01')): '';

                $logoRrc = FCPATH.'assets/docs/logo-rrc.png';

                $html = '
                    <style>
                    @page{
                        font-family: Arial, Helvetica, sans-serif;
                        font-size: 9pt;
                    }
                    .m0{
                        margin: 0;
                    }
                    .tB{
                        font-weight: bold;
                    }
                    .tC{
                        text-align: center;
                    }
                    </style>
                    <table style="width: 100%;">
                    <tr>
                        <td style="width: 15%;">
                        <img src="'.$logoRrc.'"/>
                        </td>
                        <td>
                        <p class="tB tC m0" style="text-decoration: underline; font-size: 13pt;">PT RAJA ROTI CEMERLANG</p>
                        <p class="tC m0" style="color: #494949;">BREADCRUMBS, CAKE & PASTRY</p>
                        <p class="tC m0">Kp. Pulo Kendal RT 002/003 Desa Setia Asih, Kec. Tarumajaya-Kab.Bekasi</p>
                        <p class="tC m0">Jawa Barat. Kode pos : 17215. Telp. (021) 29084611</p>
                        </td>
                    </tr>
                    </table>
                    <hr>
                    <p class="tB tC">Laporan '.$f_nama_divisi.' '.$f_nama_bulan.' '.$f_tahun.'</p>
                    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
                    <tr style="background: #cccccc">
                        <th style="width: 3%;">No</th>
                        <th style="width: 18%;">Tanggal</th>
                        <th style="width: 19%;">Shift</th>
                        <th style="width: 13%;">Divisi</th>
                        <th>Laporan</th>
                    </tr>
                ';

                $no = 0;
                foreach($laporan as $isiLaporan){
                    $no++;
                    $tanggal = date('d F Y', strtotime($isiLaporan['tanggal']));
                    $nama_shift = $isiLaporan['nama_shift'];
                    $divisi = $isiLaporan['divisi'];
                    $no_planprod = $isiLaporan['no_planprod'];
                    $jenis_oven = $isiLaporan['jenis_oven'];
                    $no_mesin = $isiLaporan['no_mesin'];
                    $produk = $isiLaporan['produk'];
                    $qty = $isiLaporan['qty'];
                    $qty_stok = explode(";", $isiLaporan['qty_stok']);
                    $qty_limbah = $isiLaporan['qty_limbah'];
                    $operator = $isiLaporan['operator'];
                    $kendala = $isiLaporan['kendala'];
                    $user = $isiLaporan['user'];
                    $html .= '
                        <tr>
                            <td class="tC">'.$no.'</td>
                            <td>'.$tanggal.'</td>
                            <td>'.$nama_shift.'</td>
                            <td>'.$divisi.'</td>
                            <td>
                    ';
                    if($isiLaporan['id_divisi']==2){
                        $html .='
                                    <table style="width: 100%" border="0">
                                        <tr>
                                            <td>Terigu</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$produk.'</td>
                                            <td style="width: 10%"></td>
                                            <td>QTY</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$qty.'</td>
                                        </tr>
                                        <tr>
                                            <td>QTY Stok</td>
                                            <td>:</td>
                                            <td colspan="5" style="color: #494949">'.$qty_stok[0].', '.$qty_stok[1].'</td>
                                        </tr>
                                        <tr>
                                            <td>QTY Limbah</td>
                                            <td>:</td>
                                            <td colspan="5" style="color: #494949">'.$qty_limbah.'</td>
                                        </tr>
                                        <tr>
                                            <td>Operator</td>
                                            <td>:</td>
                                            <td colspan="5" style="color: #494949">'.$operator.'</td>
                                        </tr>
                                        <tr>
                                            <td>Kendala</td>
                                            <td>:</td>
                                            <td colspan="5" style="color: #494949">'.$kendala.'</td>
                                        </tr>
                                    </table>
                        ';
                    }else if($isiLaporan['id_divisi']==3){
                        $html .='
                                    <table style="width: 100%" border="0">
                                        <tr>
                                            <td>No. Planprod</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$no_planprod.'</td>
                                            <td style="width: 10%"></td>
                                            <td>Jenis Baking</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$jenis_oven.'</td>
                                        </tr>
                                        <tr>
                                            <td>Produk</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$produk.'</td>
                                            <td style="width: 10%"></td>
                                            <td>QTY</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$qty.'</td>
                                        </tr>
                                        <tr>
                                            <td>Operator</td>
                                            <td>:</td>
                                            <td colspan="5" style="color: #494949">'.$operator.'</td>
                                        </tr>
                                        <tr>
                                            <td>Kendala</td>
                                            <td>:</td>
                                            <td colspan="5" style="color: #494949">'.$kendala.'</td>
                                        </tr>
                                    </table>
                        ';
                    }else if($isiLaporan['id_divisi']==4){
                        $html .='
                                    <table style="width: 100%" border="0">
                                        <tr>
                                            <td>No. Planprod</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$no_planprod.'</td>
                                            <td style="width: 10%"></td>
                                            <td>Jenis Baking</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$jenis_oven.'</td>
                                        </tr>
                                        <tr>
                                            <td>Produk</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$produk.'</td>
                                            <td style="width: 10%"></td>
                                            <td>Mesin</td>
                                            <td style="width: 1%">:</td>
                                            <td style="color: #494949">'.$no_mesin.'</td>
                                        </tr>
                                        <tr>
                                            <td>Operator</td>
                                            <td>:</td>
                                            <td colspan="5" style="color: #494949">'.$operator.'</td>
                                        </tr>
                                        <tr>
                                            <td>Kendala</td>
                                            <td>:</td>
                                            <td colspan="5" style="color: #494949">'.$kendala.'</td>
                                        </tr>
                                    </table>
                        ';
                    }
                    $html .='
                            </td>
                        </tr>
                    ';
                }
                $html .= '
                    </table>
                ';
                
                $options = new Options();
                $options->set('defaultFont', 'Courier');
                $options->set('isRemoteEnabled', TRUE);
                $options->set('debugKeepTemp', TRUE);
                $options->set('isHtml5ParserEnabled', true);
                $options->set('chroot', '');
                
                // instantiate and use the dompdf class
                $dompdf = new Dompdf($options);
                // $dompdf->loadHtmlFile(FCPATH.'assets/docs/sample-report.html');
                $dompdf->loadHtml($html);
                
                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'potrait');
                
                // Render the HTML as PDF
                $dompdf->render();
                
                // Output the generated PDF to Browser
                $this->response->setContentType('application/pdf');
                $dompdf->stream($filename, array("Attachment" => false));
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjUser()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['users'] = $this->userModel->findAll();
                for($i=0; $i<count($this->data['users']); $i++){
                    $this->data['users'][$i]['nama_divisi'] = $this->divisiModel->where('id_divisi', $this->data['users'][$i]['divisi'])->find()[0]['nama_divisi'];
                }

                return view('layouts/mnj-user.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjUserAdd()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/User/Tambah";
                $this->data['postUrl'] = base_url('mnj/user/add-act');
                $this->data['btnLabel'] = "Tambah";
                $this->data['btnStyle'] = "btn-primary";
                
                $this->data['divisis'] = $this->divisiModel->findAll();

                return view('layouts/mnj-user-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjUserAddAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $nama = $this->request->getPost('nama');
                $alamat = $this->request->getPost('alamat');
                $no_hp = $this->request->getPost('no_hp');
                $divisi = $this->request->getPost('divisi');
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                $formData = [
                    "nama" => $nama,
                    "alamat" => $alamat,
                    "no_hp" => $no_hp,
                    "divisi" => $divisi,
                    "username" => $username,
                    "password" => $password,
                ];

                $cek = $this->userModel->where("username", $username)->find();
                if(count($cek)<=0){
                    $this->userModel->insert($formData);
                    $this->session->setFlashdata("msg", "Tambah User Berhasil.");
                }else{
                    $this->session->setFlashdata("msg", "User sudah terdaftar.");
                }
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjUserEdit($id_user)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_user = explode(";", hex2bin($id_user))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/User/Edit";
                $this->data['postUrl'] = base_url('mnj/user/edit-act');
                $this->data['btnLabel'] = "Edit";
                $this->data['btnStyle'] = "btn-warning";
                
                $this->data['divisis'] = $this->divisiModel->findAll();
                
                $this->data['user'] = $this->userModel->where('id_user', $id_user)->find();
                return view('layouts/mnj-user-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjUserEditAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_user = $this->request->getPost('id_user');
                $nama = $this->request->getPost('nama');
                $alamat = $this->request->getPost('alamat');
                $no_hp = $this->request->getPost('no_hp');
                $divisi = $this->request->getPost('divisi');
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                $formData = [
                    "nama" => $nama,
                    "alamat" => $alamat,
                    "no_hp" => $no_hp,
                    "divisi" => $divisi,
                    "username" => $username,
                    "password" => $password,
                ];

                $this->userModel->update($id_user, $formData);
                $this->session->setFlashdata("msg", "Edit User Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjUserDel($id_user)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_user = explode(";", hex2bin($id_user))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/User/Hapus";
                $this->data['postUrl'] = base_url('mnj/user/del-act');
                $this->data['btnLabel'] = "Hapus";
                $this->data['btnStyle'] = "btn-danger";
                
                $this->data['divisis'] = $this->divisiModel->findAll();
                
                $this->data['user'] = $this->userModel->where('id_user', $id_user)->find();
                return view('layouts/mnj-user-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjUserDelAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_user = $this->request->getPost('id_user');

                $this->userModel->delete($id_user);
                $this->session->setFlashdata("msg", "Hapus User Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDivisi()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['divisis'] = $this->divisiModel->findAll();

                return view('layouts/mnj-divisi.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDivisiAdd()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Divisi/Tambah";
                $this->data['postUrl'] = base_url('mnj/divisi/add-act');
                $this->data['btnLabel'] = "Tambah";
                $this->data['btnStyle'] = "btn-primary";

                return view('layouts/mnj-divisi-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDivisiAddAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $nama_divisi = $this->request->getPost('nama_divisi');

                $formData = [
                    "nama_divisi" => $nama_divisi,
                ];
                
                $this->divisiModel->insert($formData);
                $this->session->setFlashdata("msg", "Tambah Divisi Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);
            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDivisiEdit($id_divisi)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_divisi = explode(";", hex2bin($id_divisi))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Divisi/Edit";
                $this->data['postUrl'] = base_url('mnj/divisi/edit-act');
                $this->data['btnLabel'] = "Edit";
                $this->data['btnStyle'] = "btn-warning";
                
                $this->data['db_divisi'] = $this->divisiModel->where('id_divisi', $id_divisi)->find();
                return view('layouts/mnj-divisi-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDivisiEditAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_divisi = $this->request->getPost('id_divisi');
                $nama_divisi = $this->request->getPost('nama_divisi');

                $formData = [
                    "nama_divisi" => $nama_divisi,
                ];

                $this->divisiModel->update($id_divisi, $formData);
                $this->session->setFlashdata("msg", "Edit Divisi Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDivisiDel($id_divisi)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_divisi = explode(";", hex2bin($id_divisi))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Divisi/Hapus";
                $this->data['postUrl'] = base_url('mnj/divisi/del-act');
                $this->data['btnLabel'] = "Hapus";
                $this->data['btnStyle'] = "btn-danger";
                
                $this->data['db_divisi'] = $this->divisiModel->where('id_divisi', $id_divisi)->find();
                return view('layouts/mnj-divisi-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDivisiDelAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_divisi = $this->request->getPost('id_divisi');

                $this->divisiModel->delete($id_divisi);
                $this->session->setFlashdata("msg", "Hapus Divisi Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjShift()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['shifts'] = $this->shiftModel->findAll();

                return view('layouts/mnj-shift.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjShiftAdd()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Shift/Tambah";
                $this->data['postUrl'] = base_url('mnj/shift/add-act');
                $this->data['btnLabel'] = "Tambah";
                $this->data['btnStyle'] = "btn-primary";

                return view('layouts/mnj-shift-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjShiftAddAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $nama_shift = $this->request->getPost('nama_shift');
                $jam_masuk = $this->request->getPost('jam_masuk');
                $jam_keluar = $this->request->getPost('jam_keluar');

                $formData = [
                    "nama_shift" => $nama_shift,
                    "jam_masuk" => $jam_masuk,
                    "jam_keluar" => $jam_keluar,
                ];
                
                $this->shiftModel->insert($formData);
                $this->session->setFlashdata("msg", "Tambah Shift Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);
            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjShiftEdit($id_shift)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_shift = explode(";", hex2bin($id_shift))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Shift/Edit";
                $this->data['postUrl'] = base_url('mnj/shift/edit-act');
                $this->data['btnLabel'] = "Edit";
                $this->data['btnStyle'] = "btn-warning";
                
                $this->data['db_shift'] = $this->shiftModel->where('id_shift', $id_shift)->find();
                return view('layouts/mnj-shift-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjShiftEditAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_shift = $this->request->getPost('id_shift');
                $nama_shift = $this->request->getPost('nama_shift');
                $jam_masuk = $this->request->getPost('jam_masuk');
                $jam_keluar = $this->request->getPost('jam_keluar');

                $formData = [
                    "nama_shift" => $nama_shift,
                    "jam_masuk" => $jam_masuk,
                    "jam_keluar" => $jam_keluar,
                ];
                
                $this->shiftModel->update($id_shift, $formData);
                $this->session->setFlashdata("msg", "Edit Shift Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);
            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjShiftDel($id_shift)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_shift = explode(";", hex2bin($id_shift))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Shift/Hapus";
                $this->data['postUrl'] = base_url('mnj/shift/del-act');
                $this->data['btnLabel'] = "Hapus";
                $this->data['btnStyle'] = "btn-danger";
                
                $this->data['db_shift'] = $this->shiftModel->where('id_shift', $id_shift)->find();
                return view('layouts/mnj-shift-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjShiftDelAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_shift = $this->request->getPost('id_shift');

                $this->shiftModel->delete($id_shift);
                $this->session->setFlashdata("msg", "Hapus Shift Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjAyaktepung()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['ayaktepungs'] = $this->tepungModel->findAll();

                return view('layouts/mnj-ayaktepung.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjAyaktepungAdd()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Ayak Tepung/Tambah";
                $this->data['postUrl'] = base_url('mnj/ayaktepung/add-act');
                $this->data['btnLabel'] = "Tambah";
                $this->data['btnStyle'] = "btn-primary";

                return view('layouts/mnj-ayaktepung-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjAyaktepungAddAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $jenis_tepung = $this->request->getPost('jenis_tepung');

                $formData = [
                    "jenis_tepung" => $jenis_tepung,
                ];
                
                $this->tepungModel->insert($formData);
                $this->session->setFlashdata("msg", "Tambah Tepung Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);
            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjAyaktepungEdit($id_ayaktepung)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_ayaktepung = explode(";", hex2bin($id_ayaktepung))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Ayak Tepung/Edit";
                $this->data['postUrl'] = base_url('mnj/ayaktepung/edit-act');
                $this->data['btnLabel'] = "Edit";
                $this->data['btnStyle'] = "btn-warning";
                
                $this->data['ayaktepung'] = $this->tepungModel->where('id_ayaktepung', $id_ayaktepung)->find();
                return view('layouts/mnj-ayaktepung-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjAyaktepungEditAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_ayaktepung = $this->request->getPost('id_ayaktepung');
                $jenis_tepung = $this->request->getPost('jenis_tepung');

                $formData = [
                    "jenis_tepung" => $jenis_tepung,
                ];

                $this->tepungModel->update($id_ayaktepung, $formData);
                $this->session->setFlashdata("msg", "Edit Tepung Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjAyaktepungDel($id_ayaktepung)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_ayaktepung = explode(";", hex2bin($id_ayaktepung))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Ayak Tepung/Hapus";
                $this->data['postUrl'] = base_url('mnj/ayaktepung/del-act');
                $this->data['btnLabel'] = "Hapus";
                $this->data['btnStyle'] = "btn-danger";
                
                $this->data['ayaktepung'] = $this->tepungModel->where('id_ayaktepung', $id_ayaktepung)->find();
                return view('layouts/mnj-ayaktepung-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjAyaktepungDelAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_ayaktepung = $this->request->getPost('id_ayaktepung');

                $this->tepungModel->delete($id_ayaktepung);
                $this->session->setFlashdata("msg", "Hapus Tepung Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjMixing()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['mixings'] = $this->mixingModel->findAll();

                return view('layouts/mnj-mixing.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjMixingAdd()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Mixing/Tambah";
                $this->data['postUrl'] = base_url('mnj/mixing/add-act');
                $this->data['btnLabel'] = "Tambah";
                $this->data['btnStyle'] = "btn-primary";

                return view('layouts/mnj-mixing-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjMixingAddAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $jenis_roti = $this->request->getPost('jenis_roti');

                $formData = [
                    "jenis_roti" => $jenis_roti,
                ];
                
                $this->mixingModel->insert($formData);
                $this->session->setFlashdata("msg", "Tambah Roti Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);
            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjMixingEdit($id_mixing)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_mixing = explode(";", hex2bin($id_mixing))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Mixing/Edit";
                $this->data['postUrl'] = base_url('mnj/mixing/edit-act');
                $this->data['btnLabel'] = "Edit";
                $this->data['btnStyle'] = "btn-warning";
                
                $this->data['mixing'] = $this->mixingModel->where('id_mixing', $id_mixing)->find();
                return view('layouts/mnj-mixing-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjMixingEditAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_mixing = $this->request->getPost('id_mixing');
                $jenis_roti = $this->request->getPost('jenis_roti');

                $formData = [
                    "jenis_roti" => $jenis_roti,
                ];

                $this->mixingModel->update($id_mixing, $formData);
                $this->session->setFlashdata("msg", "Edit Roti Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjMixingDel($id_mixing)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_mixing = explode(";", hex2bin($id_mixing))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Mixing/Hapus";
                $this->data['postUrl'] = base_url('mnj/mixing/del-act');
                $this->data['btnLabel'] = "Hapus";
                $this->data['btnStyle'] = "btn-danger";
                
                $this->data['mixing'] = $this->mixingModel->where('id_mixing', $id_mixing)->find();
                return view('layouts/mnj-mixing-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjMixingDelAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_mixing = $this->request->getPost('id_mixing');

                $this->mixingModel->delete($id_mixing);
                $this->session->setFlashdata("msg", "Hapus Roti Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDrying()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['dryings'] = $this->dryingModel->findAll();

                return view('layouts/mnj-drying.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDryingAdd()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Drying/Tambah";
                $this->data['postUrl'] = base_url('mnj/drying/add-act');
                $this->data['btnLabel'] = "Tambah";
                $this->data['btnStyle'] = "btn-primary";

                return view('layouts/mnj-drying-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDryingAddAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $jenis_label = $this->request->getPost('jenis_label');

                $formData = [
                    "jenis_label" => $jenis_label,
                ];
                
                $this->dryingModel->insert($formData);
                $this->session->setFlashdata("msg", "Tambah Label Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);
            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDryingEdit($id_drying)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_drying = explode(";", hex2bin($id_drying))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Drying/Edit";
                $this->data['postUrl'] = base_url('mnj/drying/edit-act');
                $this->data['btnLabel'] = "Edit";
                $this->data['btnStyle'] = "btn-warning";
                
                $this->data['drying'] = $this->dryingModel->where('id_drying', $id_drying)->find();
                return view('layouts/mnj-drying-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDryingEditAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_drying = $this->request->getPost('id_drying');
                $jenis_label = $this->request->getPost('jenis_label');

                $formData = [
                    "jenis_label" => $jenis_label,
                ];

                $this->dryingModel->update($id_drying, $formData);
                $this->session->setFlashdata("msg", "Edit Label Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDryingDel($id_drying)
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');

            $this->data['username'] = $sesi['nama'];
            $this->data['id_divisi'] = $sesi['divisi'];
            $this->data['divisi'] = $this->divisiModel->where('id_divisi', $sesi['divisi'])->find()[0]['nama_divisi'];
            $this->data['msg'] = $this->session->getFlashdata('msg');
            
            if($sesi['divisi']==1){
                $id_drying = explode(";", hex2bin($id_drying))[1];

                $this->data['segment1'] = $this->uri->getSegment(1);
                $this->data['segment2'] = $this->uri->getSegment(2);

                $this->data['title'] = "Manajemen/Drying/Hapus";
                $this->data['postUrl'] = base_url('mnj/drying/del-act');
                $this->data['btnLabel'] = "Hapus";
                $this->data['btnStyle'] = "btn-danger";
                
                $this->data['drying'] = $this->dryingModel->where('id_drying', $id_drying)->find();
                return view('layouts/mnj-drying-form.php', $this->data);
            }else{
                return view('layouts/denied.php', $this->data);
            }
        }else{
            return redirect()->to('login');
        }
    }

    public function mnjDryingDelAct()
    {
        if($this->session->has('userdata')){
            $sesi = $this->session->get('userdata');            
            if($sesi['divisi']==1){
                $segment1 = $this->uri->getSegment(1);
                $segment2 = $this->uri->getSegment(2);

                $id_drying = $this->request->getPost('id_drying');

                $this->dryingModel->delete($id_drying);
                $this->session->setFlashdata("msg", "Hapus Label Berhasil.");
                return redirect()->to($segment1.'/'.$segment2);

            }else{
                $this->session->setFlashdata('msg', 'Anda tidak memiliki akses.');
                return redirect()->to('logout-process');
            }
        }else{
            return redirect()->to('login');
        }
    }
}

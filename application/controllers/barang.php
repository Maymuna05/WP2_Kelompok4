<?php
class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //cek_login();
    }
    //manajemen Barang
    public function index()
    {
        $data['judul'] = 'Data Barang';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['barang'] = $this->ModelBarang->getBarang()->result_array();
        $data['kategori'] = $this->ModelBarang->getKategori()->result_array();
        $this->form_validation->set_rules('nama_barang', 'NamaBarang', 'required|min_length[3]', [
            'required' => 'Nama Barang harus diisi',
            'min_length' => 'Nama Barang terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'id_kategori',
            'Kategori',
            'required',
            ['required' => 'kategori harus diisi',]
        );
        $this->form_validation->set_rules(
            'harga',
            'Harga',
            'required|numeric',
            [
                'required' => 'Harga harus diisi',
                'numeric' => 'Yang anda masukan bukan angka'
            ]
        );
        $this->form_validation->set_rules(
            'stok',
            'Stok',
            'required|numeric',
            [
                'required' => 'Stok harus diisi',
                'numeric' => 'Yang anda masukan bukan angka'
            ]
        );
        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('barang/index', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data();
                $gambar = $image['file_name'];
            } else {
                $gambar = '';
            }
            $data = [
                'nama_barang' => $this->input->post(
                    'nama_barang',
                    true
                ),
                'id_kategori' => $this->input->post(
                    'id_kategori',
                    true
                ),
                'harga' => $this->input->post('harga', true),
                'stok' => $this->input->post('stok', true),
                'dibeli' => 0,
                'image' => $gambar
            ];
            $this->ModelBarang->simpanBarang($data);
            redirect('barang');
        }
    }

    public function hapusBarang()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelBarang->hapusBarang($where);
        redirect('barang');
    }


    //manajemen kategori
    public function kategori()
    {
        $data['judul'] = 'Kategori Barang';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->ModelBarang->getKategori()->result_array();
        $this->form_validation->set_rules('kategori', 'Kategori', 'required', ['required' => 'Nama Barang harus diisi']);
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('barang/kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'kategori' => $this->input->post('kategori')
            ];

            $this->ModelBarang->simpanKategori($data);
            redirect('barang/kategori');
        }
    }

    public function hapusKategori()
    {
        $where = ['id_kategori' => $this->uri->segment(3)];
        $this->ModelBarang->hapusKategori($where);
        redirect('barang/kategori');
    }

    public function ubahBarang()
    {
        $data['judul'] = 'Ubah Data Barang';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['barang'] = $this->ModelBarang->barangWhere(['id' => $this->uri->segment(3)])->result_array();
        $kategori = $this->ModelBarang->joinKategoriBarang(['barang.id' => $this->uri->segment(3)])->result_array();
        foreach ($kategori as $k) {
            $data['id'] = $k['id_kategori'];
            $data['k'] = $k['kategori'];
        }
        $data['kategori'] = $this->ModelBarang->getKategori()->result_array();
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|min_length[3]', [
            'required' => 'Nama Barang harus diisi',  'min_length' => 'Nama Barang terlalu pendek'
        ]);
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required', [
            'required' => 'Kategori harus diisi',
        ]);
        $this->form_validation->set_rules(
            'harga',
            'Nomor Harga',
            'required|min_length[3]|numeric',
            [
                'required' => 'Harga harus diisi',
                'numeric' => 'Yang anda masukan bukan angka'
            ]
        );
        $this->form_validation->set_rules(
            'stok',
            'Stok',
            'required|numeric',
            [
                'required' => 'Stok harus diisi',
                'numeric' => 'Yang anda masukan bukan angka'
            ]
        );
        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();
        //memuat atau memanggil library upload
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('barang/ubah_barang', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data();
                unlink('assets/img/upload/' . $this->input->post('old_pict', TRUE));
                $gambar = $image['file_name'];
            } else {
                $gambar = $this->input->post('old_pict', TRUE);
            }
            $data = [
                'nama_barang' => $this->input->post('nama_barang', true),
                'id_kategori' => $this->input->post('id_kategori', true),
                'harga' => $this->input->post('harga', true),
                'stok' => $this->input->post('stok', true),
                'image' => $gambar
            ];
            $this->ModelBarang->updateBarang($data, ['id' => $this->input->post('id')]);
            redirect('barang');
        }
    }
    public function ubahKategori()
    {
        $data['judul'] = 'Ubah Data Kategori';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->ModelBarang->kategoriWhere(['id' => $this->uri->segment(3)])->result_array();


        $this->form_validation->set_rules('kategori', 'Kategori', 'required|min_length[3]', [
            'required' => 'Kategori harus diisi',
            'min_length' => 'Kategori terlalu pendek'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('barang/ubah_kategori', $data);
            $this->load->view('templates/footer');
        } else {

            $data = [
                'kategori' => $this->input->post('kategori', true)
            ];

            $this->ModelBarang->updateKategori(['id' => $this->input->post('id')], $data);
            redirect('barang/kategori');
        }
    }
}

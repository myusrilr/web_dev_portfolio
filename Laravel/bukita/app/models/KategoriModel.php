<?php
class KategoriModel
{
    private $table = 'kategori';
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllKategori()
    {
        $this->db->query("SELECT * FROM " . $this->table);
        return $this->db->resultSet();
    }

    public function getKategoriById($id)
    {
        $query = "SELECT * FROM kategori WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }
    public function tambahKategori($data)
    {
        $query = "INSERT INTO kategori (nama_kategori) VALUES(:nama_kategori)";

        $this->db->query($query);
        $this->db->bind('nama_kategori', $data['nama_kategori']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateDataKategori($data)
    {
        // Ensure the query matches the bound parameters
        $query = "UPDATE kategori SET nama_kategori = :nama_kategori WHERE id = :id";
        $this->db->query($query);

        // Bind all necessary parameters
        $this->db->bind('nama_kategori', $data['nama_kategori']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();  // Return the number of affected rows
    }
    public function deleteKategori($id)
    {
        $this->db->query("DELETE FROM $this->table WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function carikategori()
    {
        $key = $_POST['key'];
        $query = "SELECT * FROM $this->table WHERE nama_kategori LIKE :key";
        $this->db->query($query);
        $this->db->bind('key', "%$key%");
        return $this->db->resultSet();
    }
}

<?php
class Animal {
    public $animals = ["kucing", "harimau", "kelinci", "buaya", "ular"];

    function index(){
        echo "<ol>";
        foreach ($this->animals as $key => $value){
            echo "<li>$value</li>";
        }
        echo "</ol>";
    }
    function store($hewan){
        array_push($this->animals, $hewan);

        $this->index();
    } 

    public function update($key, $value)
    {
        if(isset($this->animals[$key])){
        $this->animals[$key] = $value;
        //memanggil index
        $this->index();
        } else{
            echo "hewan tidak ditemukan";
        }
    }
    public function destroy($key){
        if(isset($this->animals[$key])){
            unset($this->animals[$key]);
            //memanggil menthod index
            $this->index();
            } else{
                echo "hewan tidak ditemukan";
            }


    }
}

$hewan= new Animal();
echo "Index - menampilkan seluruh data hewan <br>";
$hewan->index();
echo "<br>";

$hewan= new Animal();
echo "Store - Menambahkan data hewan baru (Burung) <br>";
$hewan->store("Burung");
echo "<br>";

echo "Update - Mengubah data hewan <br>";
$hewan->update(6    , "kucing anggora");
echo "<br>";

echo "Destroy - Menghapus data hewan <br>";
$hewan->destroy(0);
echo "<br>";

?>
// import * as THREE from './node_modules/three/build/three.module.js';
import * as THREE from 'three';


/*

Scene
- Lingkungan 3D yang akan menjadi aplikasi kita
- 3D world
Camera
- kamera yang lota gunakan untuk melihat 3D world tersebut
Renderer
- yang menampilkan hasilnya dari kamera ke layar (WebGL Randerer)
*/

var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.z = 5;
// nilai dari  z adalah jarak kamera dari objek yang kita buat. 
/* 
 ada 4 parameter :
 1. FOV. semakin kecil FOV, maka kamera akan semakin kecil pula. begitu sebaliknya semakin besar FOV, maka semakin besar pula kameranya
 2. aspectratio. ini disesuaikan dengan layar kita (innerwidth,innerheight)
 3. near clip - seberapa dekat apa yang dilihat oleh kamera kita
 4. far clip - seberapa jauh kamera kita bisa melihat kayak jarak pandangnya. semakin jauh, maka akan semakin berat 
*/

var renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);


// ini buat sendiri Objek geometris (geo_saya)
const geo_saya = new THREE.BufferGeometry();
//seperti sebuah tempat penyimpanan,bedanya kalau di geometry itu bentuknya sudah tersedia. nah, kalau ini bisa buat sendiri kayak array. pembangun bangun 3D terdiri dari titik sudut yang disebut dnegan vertex. dalam membuat arry,gunakan typed array agar lebih aman dan cepat. pastikan nilainya itu floating point atau 32 bit
let vertices = new Float32Array([
    -1.0, -1.0, 1.0, // indeks ke-0
    1.0, 1.0, 1.0, // indeks ke-1
    -1.0, 1.0, 1.0, // indeks ke-2
    1.0, -1.0, 1.0, // indeks ke-3

    -1.0, -1.0, -1.0, // indeks ke-4
    1.0, 1.0, -1.0, // indeks ke-5
    -1.0, 1.0, -1.0, // indeks ke-6
    1.0, -1.0, -1.0  // indeks ke-7
]);
// array yang menyimpan berbagai vertex. kata vertices jamak dari vertex
let colors = new Float32Array([
    // Sisi depan (merah)
    1.0, 0.0, 0.0,  // Vertex 0
    1.0, 0.0, 0.0,  // Vertex 1
    1.0, 1.0, 0.0,  // Vertex 2
    1.0, 1.0, 0.0,  // Vertex 3
    0.0, 1.0, 0.0,  // Vertex 4
    0.0, 1.0, 0.0,  // Vertex 5
    0.0, 0.0, 1.0,  // Vertex 6
    0.0, 0.0, 1.0,  // Vertex 7
]);
geo_saya.setAttribute('position', new THREE.BufferAttribute(vertices, 3));
geo_saya.setAttribute('color', new THREE.BufferAttribute(colors, 3));
// fungsi setAttribute digunakan untuk menambahkan atribut ke geometry. 
//1. 'position' adalah atribut yang kita buat.
//2. new THREE.BufferAttribute(vertices, 3). vertices adalah array yang kita buat di atas. 3 adalah jumlah atribut yang kita buat.

geo_saya.setIndex([
    // sisi depan
    0, 3, 1,
    1, 2, 0,

    // sisi belakang
    4, 6, 5,
    5, 7, 4,

    // sisi kiri
    4, 0, 2,
    2, 6, 4,

    // sisi kanan
    5, 1, 3,
    3, 7, 5,

    // sisi atas
    1, 5, 6,
    6, 2, 1,

    // sisi bawah
    0, 4, 7,
    7, 3, 0
]);
//cara ke-1
// const mat_saya = new THREE.MeshBasicMaterial({vertexColors: THREE.VertexColors});
//cara ke-2
const mat_saya = new THREE.MeshBasicMaterial({vertexColors: true, wireframe: true});
const mesh_saya = new THREE.Mesh(geo_saya, mat_saya);
scene.add(mesh_saya);
// fungsi add digunakan untuk menambahkan objek ke scene.

// ini ngambil dari 3D Primitives
const geometry = new THREE.CylinderGeometry(5, 5, 20, 32);
const material = new THREE.MeshBasicMaterial({ color: 0xffff00 });
const cylinder = new THREE.Mesh(geometry, material);
scene.add(cylinder);


window.addEventListener('resize', function () {
    renderer.setSize(window.innerWidth, window.innerHeight);
    // fungsi ini digunakan untuk mengatur ukuran window kita
    camera.aspect = window.innerWidth / window.innerHeight;
    // fungsi ini digunakan untuk mengatur ukuran kamera kita 
    camera.updateProjectionMatrix();
    // fungsi ini digunakan untuk mengupdate ukuran kamera kita
});

function draw() {
    requestAnimationFrame(draw);
    // fungsi requestAnimationFrame digunakan untuk membuat animasi
    mesh_saya.rotation.y += 0.01;
    //agar bisa memutar ke sisi kiri dan kanan
    mesh_saya.rotation.x += 0.01;
    //agar bisa memutar ke atas dan bawah
    // mesh_saya.rotation.z += 0.01;
    // //agar bisa memutar ke atas dan bawah


    renderer.render(scene, camera);
}
draw();
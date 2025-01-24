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
camera.position.z = 80;
// posisi kamera kita
/* 
 ada 4 parameter :
 1. FOV. semakin kecil FOV, maka kamera akan semakin kecil pula. begitu sebaliknya semakin besar FOV, maka semakin besar pula kameranya
 2. aspectratio. ini disesuaikan dengan layar kita (innerwidth,innerheight)
 3. near clip - seberapa dekat apa yang dilihat oleh kamera kita
 4. far clip - seberapa jauh kamera kita bisa melihat kayak jarak pandangnya. semakin jauh, maka akan semakin berat 
*/

// ini ngambil dari 3D Primitives
const geometry = new THREE.CylinderGeometry(5, 5, 20, 32);//ukuran dari object kita (p,l,t)
const material = new THREE.MeshBasicMaterial({ color: 0x00ff00 });// warna dari object kita, yakni hijau (r g b) pokoknya angkanya kita isi dengan hurf f, maka akan muncul warnanya itu
const cylinder = new THREE.Mesh(geometry, material);// membuat object kita dengan membuat mesh(bentuk 3D yang terdiri dari geometry yang menyatakan bentuknya dan material yang menyatakan tampilannya dari warnanya, dll.)
scene.add(cylinder);

var renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);


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
    cylinder.rotation.y += 0.01;
    //agar bisa memutar ke sisi kiri dan kanan
    cylinder.rotation.x += 0.01;
    // //agar bisa memutar ke atas dan bawah
    cylinder.rotation.z += 0.01;
    // //agar bisa memutar ke atas dan bawah

    // fungsi requestAnimationFrame digunakan untuk membuat animasi
    renderer.render(scene, camera);
}
draw();
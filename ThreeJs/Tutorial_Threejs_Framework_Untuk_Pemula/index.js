// import * as THREE from './node_modules/three/build/three.module.js';
import * as THREE from 'three';
import { OrbitControls } from './node_modules/three/examples/jsm/controls/OrbitControls.js';


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
/* 
 ada 4 parameter :
 1. FOV. semakin kecil FOV, maka kamera akan semakin kecil pula. begitu sebaliknya semakin besar FOV, maka semakin besar pula kameranya
 2. aspectratio. ini disesuaikan dengan layar kita (innerwidth,innerheight)
 3. near clip - seberapa dekat apa yang dilihat oleh kamera kita
 4. far clip - seberapa jauh kamera kita bisa melihat kayak jarak pandangnya. semakin jauh, maka akan semakin berat 
*/
var renderer = new THREE.WebGLRenderer();
var box = new THREE.BoxGeometry(1, 1, 1); // 1,1,1 adalah ukuran dari object kita (p,l,t)
var boxMat = new THREE.MeshBasicMaterial({ color: 0x00f000 });// warna dari object kita, yakni hijau (r g b) pokoknya angkanya kita isi dengan hurf f, maka akan muncul warnanya itu

var boxMesh = new THREE.Mesh(box, boxMat);// membuat object kita dengan membuat mesh(bentuk 3D yang terdiri dari geometry yang menyatakan bentuknya dan material yang menyatakan jenisnya dari warnanya, dll.)
scene.add(boxMesh);
camera.position.z = 5;
// nilai dari  z adalah jarak kamera dari objek yang kita buat. jadi semakin kecil nilainya maka objectnya akan semakin memenuhi layarnya dan begitu sebaliknya


renderer.setSize(window.innerWidth, window.innerHeight);
//
document.body.appendChild(renderer.domElement);
//

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
    boxMesh.rotation.y += 0.01;
    //agar bisa memutar ke sisi kiri dan kanan
    boxMesh.rotation.x += 0.01;
    //agar bisa memutar ke atas dan bawah
    boxMesh.rotation.z += 0.01;
    //agar bisa memutar ke atas dan bawah

    // fungsi requestAnimationFrame digunakan untuk membuat animasi
    renderer.render(scene, camera);
}
draw();
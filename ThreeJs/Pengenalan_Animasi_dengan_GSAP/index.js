import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

let scene = new THREE.Scene();
let cam = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 1000);
scene.background = new THREE.Color(0xfafafa);
cam.position.z += 25;
cam.position.y += 10;

let renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setPixelRatio(devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

let controls = new OrbitControls(cam, renderer.domElement);

let grid = new THREE.GridHelper(100, 20, 0x0a0a0a, 0x0a0a0a);
grid.position.y -= 1.5;
scene.add(grid);

let pLight = new THREE.PointLight(0x00ff00, 1000);
pLight.position.set(1, 15, 15);
scene.add(pLight);
scene.add(new THREE.PointLightHelper(pLight, 0.1, 0x00ff00));



let cGeo = new THREE.BoxGeometry(3, 3, 3);
let cMat = new THREE.MeshLambertMaterial({ color: 0x00ff00 });
let cMesh = new THREE.Mesh(cGeo, cMat);
scene.add(cMesh);

// //animasi yang langsung jalan. animasinya bisa ditumpuk dan berjalan berbarengan. untuk bisa tau lebih lanjut bisa liat ke documentation gsap

// //1.animasi berpidah tempat (1)
// gsap.to(cMesh.position, { y: 5, duration: 5 });
// //pas dijalanin, maka objeknya akan bergeser ke arah nilai yang kita berikan dari posisi awalnya. 

//2.animasi berpindah tempat (2)
// gsap.from(cMesh.position, { y: 5, duration: 5 });
// kebalikannya gsap.to (). pas dijalanin, maka objeknya akan bergeser dari arah nilai yang kita berikan ke posisi awalnya.

// //3. animasi berputar
// gsap.to(cMesh.rotation, { y: 5, duration: 5 });

// //animasi yang tidak langsung jalan. jadi, bisa kita simpan dahulu dan baru bisa kita jalankan pas ada event baru tertentu 

// let tween1 = gsap.to(cMesh.position, { y: 5, duration: 5, paused: true });
// let tween2 = gsap.to(cMesh.rotation, { y: 5, duration: 5, paused: true });

// tween1.play();
// // tween2.play();

// //animasi yang berurutan menggunakan timeline. jadi, kita bisa mengumpulkan beberapa animasi yang kita buat dan kita jalankan secara berurutan. ada banyak fungsi pada timeline di gsap documentation. salah satunya seek yang bisa pindah ke detik tertentu
// let t1 = gsap.timeline();
// t1.to(cMesh.position, { x: 5 });
// t1.to(cMesh.position, { z: 5 });
// t1.to(cMesh.position, { x: -5 });
// t1.to(cMesh.position, { z: -5 });
// t1.to(cMesh.scale, { x: 2, y: 2 });

// //menggunakan timeline pada saat event tertentu
// //1. mengklik titik bagian tertentu pada scene kita
// let t1 = gsap.timeline({ paused: true });
// t1.to(cMesh.position, { x: 5 });
// t1.to(cMesh.position, { z: 5 });
// t1.to(cMesh.position, { x: -5 });
// t1.to(cMesh.position, { z: -5 });
// t1.to(cMesh.scale, { x: 2, y: 2 });

// addEventListener('mousedown', function (e) {
//     t1.play();
// });

// //2. restart dengan mengklik titik bagian tertentu pada scene kita
// let t1 = gsap.timeline({ paused: true });
// t1.to(cMesh.position, { x: 5 });
// t1.to(cMesh.position, { z: 5 });
// t1.to(cMesh.position, { x: -5 });
// t1.to(cMesh.position, { z: -5 });
// t1.to(cMesh.scale, { x: 2, y: 2 });

// let ganjil = false;

// addEventListener('mousedown', function (e) {
//     if (ganjil == false) {
//         t1.play();
//         ganjil = false;
//     } else {
//         t1.restart();
//     }
//     ganjil = !ganjil;
// });

// //3. reverse dengan mengklik titik bagian tertentu pada scene kita
// let t1 = gsap.timeline({ paused: true });
// t1.to(cMesh.position, { x: 5 });
// t1.to(cMesh.position, { z: 5 });
// t1.to(cMesh.position, { x: -5 });
// t1.to(cMesh.position, { z: -5 });
// t1.to(cMesh.scale, { x: 2, y: 2 });

// let ganjil = false;

// addEventListener('mousedown', function (e) {
//     if (ganjil == false) {
//         t1.play();
//         ganjil = false;
//     } else {
//         t1.reverse();
//     }
//     ganjil = !ganjil;

// });

//nesting. jadi, kita mengumpulkannnya ke dalam satu master timeline dna dia akan mengekseskusi timeline yang kita buat secara berurutan

let t1 = gsap.timeline();
t1.to(cMesh.position, { x: 5 });
t1.to(cMesh.position, { z: 5 });
t1.to(cMesh.position, { x: -5 });
t1.to(cMesh.position, { z: -5 });
t1.to(cMesh.scale, { x: 2, y: 2 });

let t2 = gsap.timeline();
t2.to(cMesh.position, { x: -5 });
t2.to(cMesh.position, { z: -5 });
t2.to(cMesh.position, { x: 5 });
t2.to(cMesh.position, { z: 5 });
t2.to(cMesh.scale, { x: -2, y: -2 });

let t = gsap.timeline({ paused: true });
t.add(t1);
t.add(t2);


let ganjil = false;

addEventListener('mousedown', function (e) {
    if (ganjil == false) {
        t.play();
        ganjil = false;
    } else {
        t.reverse();
    }
    ganjil = !ganjil;

});



function draw() {
    // cMesh.position.x += 0.01
    // //posisinya terus ke arah kanan
    renderer.render(scene, cam);
    requestAnimationFrame(draw);
}
draw();

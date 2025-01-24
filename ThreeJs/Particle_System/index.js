import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

// Membuat Scene, Kamera, dan Renderer
var scene = new THREE.Scene();
var cam = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 1000);
var renderer = new THREE.WebGLRenderer({ antialias: true });

renderer.setSize(window.innerWidth, window.innerHeight);
cam.position.z = 100;
cam.position.y = 5;

document.body.appendChild(renderer.domElement);

var directionalLight = new THREE.DirectionalLight(0xffffff, 100);
directionalLight.position.set(0, 1, 0);
directionalLight.castShadow = true;
scene.add(directionalLight);

var ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
scene.add(ambientLight);

let cubeMesh = new THREE.Mesh(
    new THREE.BoxGeometry(1, 1, 1),
    new THREE.MeshPhongMaterial({ color: 0x0000ff })
);
scene.add(cubeMesh);

let gr = new THREE.GridHelper(100, 20, 0xfafafa, 0xfafafa);
gr.position.set(0, -0.5, 0);
scene.add(gr);

// //membuat partikel.
// //1.menggunakan geometry built-in berupa sphere dengan membuat setiap vertexnya menjadi persegi 2D yang selalu menghadap kamera
// let pGeo = new THREE.SphereGeometry(3, 30, 30);
// let pMat = new THREE.PointsMaterial({
//     size: 0.2,
//     color: 0x00ff00,
// });
// let partikel = new THREE.Points(pGeo, pMat);
// //yang dibuat ini bukan mesh, tapi sebuah partikel
// scene.add(partikel);

//2.Membuat Partikel menggunakan BufferGeometry
let kump_titik = [];
let jml = 10;
//walaupun ada banyak partikel, tetapi tidak melambat proses rendernya
const particlePositions = new Float32Array(jml * jml * 3); // x, y, z for each particle
const pGeo = new THREE.BufferGeometry();

// //a. pembuatan partikel bintang
// for (let i = 0; i < jml; i++) {
//     for (let j = 0; j < jml; j++) {
//         const idx = (i * jml + j) * 3;
//         const posisi = new THREE.Vector3(i-jml/2, 0, Math.j-jml/2);
//         const kecepatan = new THREE.Vector3(0, Math.random() * 0.01, 0);

//         kump_titik.push({ posisi, kecepatan });

//         particlePositions[idx] = posisi.x;
//         particlePositions[idx + 1] = posisi.y;
//         particlePositions[idx + 2] = posisi.z;
//     }
// }

//b. pembuatan partikel asap
for (let i = 0; i < jml; i++) {
    for (let j = 0; j < jml; j++) {
        const idx = (i * jml + j) * 3;
        const posisi = new THREE.Vector3(Math.random(), 0, Math.random());
        const kecepatan = new THREE.Vector3(0, Math.random() * 0.01, 0);

        kump_titik.push({ posisi, kecepatan });

        particlePositions[idx] = posisi.x;
        particlePositions[idx + 1] = posisi.y;
        particlePositions[idx + 2] = posisi.z;
    }
}

// //c. pembuatan partikel meledak
// for (let i = 0; i < jml; i++) {
//     for (let j = 0; j < jml; j++) {
//         const idx = (i * jml + j) * 3;

//         // Define each particle’s position and velocity
//         const posisi = new THREE.Vector3(0, 0, 0);
//         const kecepatan = new THREE.Vector3(
//             Math.random() * 0.03,
//             Math.random() * 0.03,
//             Math.random() * 0.03
//         );

//         kump_titik.push({ posisi, kecepatan });

//         // Set initial positions in the Float32Array
//         particlePositions[idx] = posisi.x;
//         particlePositions[idx + 1] = posisi.y;
//         particlePositions[idx + 2] = posisi.z;
//     }
// }

// Set positions attribute for BufferGeometry
pGeo.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));

// Load Texture for Particles
let fText = new THREE.TextureLoader().load('texture/flare.png');

const particleMaterial = new THREE.PointsMaterial({
    size: 3,
    map: fText,
    transparent: true,
    depthTest: false,
});

const particles = new THREE.Points(pGeo, particleMaterial);
scene.add(particles);

// Orbit Controls
const controls = new OrbitControls(cam, renderer.domElement);

// Animation Loop
function drawScene() {
    kump_titik.forEach((titik, index) => {
        if (titik.posisi.y > 51) {
            titik.posisi.y = 0; // Reset particle position when it goes out of bounds
        }

        // Randomly adjust velocity for each frame
        titik.kecepatan.y = Math.random() * 1;

        // Update particle position by adding velocity
        titik.posisi.add(titik.kecepatan);

        // Update particlePositions array
        const idx = index * 3;
        particlePositions[idx] = titik.posisi.x;
        particlePositions[idx + 1] = titik.posisi.y;
        particlePositions[idx + 2] = titik.posisi.z;
    });

    // Mark position attribute as needing update
    pGeo.attributes.position.needsUpdate = true;

    particles.rotation.y += 0.001; // Rotate particle system for effect

    renderer.render(scene, cam);
    requestAnimationFrame(drawScene);
}

drawScene();
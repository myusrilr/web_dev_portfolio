// import * as THREE from './node_modules/three/build/three.module.js';
import * as THREE from 'three';
import { OrbitControls } from './node_modules/three/examples/jsm/controls/OrbitControls.js';

const scene = new THREE.Scene();
const cam = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

const renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
cam.position.z = 5;

document.body.appendChild(renderer.domElement);


// Tambahkan kontrol orbit
const controls = new OrbitControls(cam, renderer.domElement);

// Tambahkan kotak 3D ke scene
const box = new THREE.Mesh(
    new THREE.BoxGeometry(1, 1, 1),
    new THREE.MeshBasicMaterial({ color: 0xff0000 })
);
scene.add(box);

// Fungsi untuk menggambar dan animasi
const draw = () => {
    controls.update();
    box.rotation.x += 0.01;
    box.rotation.y += 0.01;
    renderer.render(scene, cam);
    requestAnimationFrame(draw);
};

draw();

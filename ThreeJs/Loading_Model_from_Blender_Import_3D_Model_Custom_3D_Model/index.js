import * as THREE from './node_modules/three/build/three.module.js';
import { OrbitControls } from './node_modules/three/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from './node_modules/three/examples/jsm/loaders/GLTFLoader.js';

// Membuat Scene, Kamera, dan Renderer
let scene = new THREE.Scene();
let cam = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
let renderer = new THREE.WebGLRenderer({ antialias: true });

cam.position.set(0, 5, 10);
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setPixelRatio(window.devicePixelRatio);
document.body.appendChild(renderer.domElement);

scene.background = new THREE.Color(0xfafafa);

// Orbit Controls
let controls = new OrbitControls(cam, renderer.domElement);

// Tekstur Plane
let texture = new THREE.TextureLoader().load('./texture/leaf.jpg');

// Muat Model dari Blender (GLTF)
let loader = new GLTFLoader();
let monyet;  // Deklarasikan variabel monyet di luar fungsi loader.load

loader.load('./model/monkey.glb', function (result) {
    monyet = result.scene;  // Inisialisasi monyet di sini
    scene.add(monyet);  // Menambahkan model ke scene
});

// Membuat Plane dengan Tekstur
let pGeo = new THREE.PlaneGeometry(10, 10);
let pMat = new THREE.MeshPhongMaterial({ map: texture, side: THREE.DoubleSide });
let pMesh = new THREE.Mesh(pGeo, pMat);
pMesh.rotation.x = -Math.PI / 2;
pMesh.position.y = -1;
pMesh.receiveShadow = true;
scene.add(pMesh);

// Cahaya untuk Scene
let pLight = new THREE.PointLight(0x00ff00, 1, 100000);
pLight.position.set(1, 1, 1);
pLight.castShadow = true;  // Aktifkan bayangan pada cahaya
scene.add(pLight);
scene.add(new THREE.PointLightHelper(pLight, 0.5));

// Loop Animasi
function update() {
    // if (monyet) {
    //     monyet.rotation.y += 0.01;  // Rotasi model
    // }
    controls.update();  // Update kontrol kamera
    renderer.render(scene, cam);
    requestAnimationFrame(update);
}
update();

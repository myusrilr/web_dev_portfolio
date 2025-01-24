import * as THREE from "https://cdn.skypack.dev/three@0.136.0";
import { GLTFLoader } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/loaders/GLTFLoader.js";
import { OrbitControls } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/controls/OrbitControls";

// Ambil elemen wrapper
const wrapper = document.getElementById('tree_wrapper');

// Inisialisasi scene, kamera, dan renderer
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, wrapper.clientWidth / wrapper.clientHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer();
renderer.setSize(wrapper.clientWidth, wrapper.clientHeight);
wrapper.appendChild(renderer.domElement);
scene.background = new THREE.Color(0xC2FFC7);

// Tambahkan pencahayaan
const ambientLight = new THREE.AmbientLight(0xffffff, 6.5);
scene.add(ambientLight);
const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
directionalLight.position.set(5, 10, 7.5);
scene.add(directionalLight);

// Orbit controls
const controls = new OrbitControls(camera, renderer.domElement);

// Atur posisi kamera
camera.position.set(85, 16, 28); // Sesuaikan jarak dan ketinggian kamera
camera.lookAt(85, 16, 28); // Fokuskan kamera ke bagian tengah pohon (sesuaikan tinggi jika perlu)

// Loader GLTF
const loader = new GLTFLoader();
loader.load(
  '/3D_Assets/tree.gltf', // Path ke file GLTF
  (gltf) => {
    const model = gltf.scene;

    // Pastikan model berada di tengah
    const box = new THREE.Box3().setFromObject(model);
    const center = box.getCenter(new THREE.Vector3());
    model.position.sub(center); // Pindahkan model ke pusat

    model.scale.set(1, 1, 1); // Atur skala model
    scene.add(model);
  },
);

// Sesuaikan ukuran saat jendela diubah
window.addEventListener('resize', () => {
  camera.aspect = wrapper.clientWidth / wrapper.clientHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(wrapper.clientWidth, wrapper.clientHeight);
});

// Animasi
function animate() {
  requestAnimationFrame(animate);
  controls.update();
  renderer.render(scene, camera);
}
animate();

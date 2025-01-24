import * as THREE from "https://cdn.skypack.dev/three@0.136.0";
import gsap from 'https://cdn.skypack.dev/gsap';
import { GLTFLoader } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/loaders/GLTFLoader.js";
import { DRACOLoader } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/loaders/DRACOLoader.js";
import { OrbitControls } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/controls/OrbitControls";

// Inisialisasi dan konfigurasi
let v3 = new THREE.Vector3();
var container = document.getElementById("body_3D");
var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera(45, container.offsetWidth / container.offsetHeight, 0.1, 1000);
var renderer = new THREE.WebGLRenderer();
renderer.toneMapping = THREE.ReinhardToneMapping;
renderer.setSize(container.offsetWidth, container.offsetHeight);
container.appendChild(renderer.domElement);
scene.background = new THREE.Color(0xC2FFC7);

// / Menambahkan cahaya ambient (untuk pencahayaan umum)
var ambientLight = new THREE.AmbientLight(0xFFFFFF, 2.5); // Cahaya ambient dengan warna abu-abu
scene.add(ambientLight);

const loader = new GLTFLoader();
const dracoLoader = new DRACOLoader();
let island; // Deklarasi global untuk island

// Set path ke decoder Draco
dracoLoader.setDecoderPath('https://cdn.jsdelivr.net/npm/three@0.136.0/examples/js/libs/draco/');
loader.setDRACOLoader(dracoLoader);

// Fungsi untuk memuat model pulau
function loadIsland() {
    loader.load('/3D_Assets/island.glb', (gltf) => {
        island = gltf.scene;
        scene.add(island);
        island.position.set(0, 0, 0); // Atur posisi pulau

        // Setelah pulau dimuat, panggil fungsi untuk menambahkan cube dan bubble chat
        addCubesWithBubbleChat(island);
    });
}

// Fungsi untuk menambahkan cube dan bubble chat ke pulau
async function addCubesWithBubbleChat(island) {
    const titles = await fetchTikTitles(); // Ambil data title dari Laravel

    // Tentukan posisi untuk setiap cube
    const positions = [
        new THREE.Vector3(18, 0, 14),  // HTML
        new THREE.Vector3(18, 0, -16),  // PHP
        new THREE.Vector3(18, 0, 9),   // JS
        new THREE.Vector3(15, 0, 8),     // CSS
    ];

    titles.forEach((title, index) => {
        const position = positions[index % positions.length]; // Loop posisi jika titles lebih banyak dari posisi

        // Tambahkan cube
        const cubeGeometry = new THREE.BoxGeometry(4, 15, 4);
        const cubeMaterial = new THREE.MeshStandardMaterial({
            color: 0xFF0000,
            wireframe: true,
            transparent: true,
            opacity: 0,
        });
        const cube = new THREE.Mesh(cubeGeometry, cubeMaterial);
        cube.position.copy(position);
        island.add(cube);

        // Tambahkan bubble chat di atas cube
        const bubblePosition = position.clone().add(new THREE.Vector3(0, 10, 0)); // Bubble di atas cube
        createBubbleChat(title, bubblePosition);
    });
}

// Fungsi untuk membuat bubble chat
function createBubbleTexture(text, width, height) {
    const scaleFactor = 2;
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    canvas.width = width * scaleFactor;
    canvas.height = height * scaleFactor;
    context.scale(scaleFactor, scaleFactor);

    // Background Bubble
    context.fillStyle = '#FFFFFF';
    context.strokeStyle = 'rgba(0, 0, 0, 0.5)';
    context.lineWidth = 3;
    const borderRadius = 15;
    const tailWidth = 10;
    const tailHeight = 15;
    const tailPosition = width - 60;
    context.beginPath();
    context.moveTo(borderRadius, 0);
    context.lineTo(width - borderRadius, 0);
    context.quadraticCurveTo(width, 0, width, borderRadius);
    context.lineTo(width, height - borderRadius);
    context.quadraticCurveTo(width, height, width - borderRadius, height);
    context.lineTo(tailPosition, height);
    context.lineTo(tailPosition - tailWidth, height + tailHeight);
    context.lineTo(tailPosition - tailWidth * 2, height);
    context.lineTo(borderRadius, height);
    context.quadraticCurveTo(0, height, 0, height - borderRadius);
    context.lineTo(0, borderRadius);
    context.quadraticCurveTo(0, 0, borderRadius, 0);
    context.closePath();
    context.fill();
    context.stroke();

    // Text
    context.font = 'bold 12px Arial';
    context.fillStyle = '#526E48';
    context.textAlign = 'center';
    context.textBaseline = 'middle';
    context.fillText(text, width / 2, height / 2);

    const texture = new THREE.CanvasTexture(canvas);
    texture.needsUpdate = true;

    return texture;
}

function createBubbleChat(text, position) {
    const texture = createBubbleTexture(text, 110, 55);

    const bubbleMaterial = new THREE.SpriteMaterial({
        map: texture,
        transparent: true
    });

    const bubbleChat = new THREE.Sprite(bubbleMaterial);
    bubbleChat.scale.set(2, 1, 1); // Skala bisa disesuaikan
    bubbleChat.position.copy(position);
    bubbleChat.position.add(new THREE.Vector3(0, 1, 0)); // Sesuaikan posisi y

    gsap.from(bubbleChat.scale, {
        x: 0,
        y: 0,
        z: 0,
        duration: 1,
        ease: 'power2.easeIn'
    });

    scene.add(bubbleChat);
    return bubbleChat;
}

// Fungsi untuk mengambil data dari API Laravel
async function fetchTikTitles() {
    const response = await fetch('/api/tik/titles');
    const titles = await response.json();
    return titles;
}
// Fungsi untuk menangani klik pada bubble chat
function handleBubbleClick(clickedObject) {
    // Periksa apakah objek yang diklik adalah sprite (bubble chat)
    if (clickedObject.isSprite) {
        // Arahkan pengguna ke halaman yang diinginkan
        window.location.href = 'http://127.0.0.1:8000/guru/'; // Ubah URL sesuai kebutuhan
    }
}

// Menambahkan event listener untuk klik
window.addEventListener('click', (event) => {
    // Normalisasi koordinat mouse
    const mouse = new THREE.Vector2();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    const raycaster = new THREE.Raycaster();
    raycaster.setFromCamera(mouse, camera);

    const intersects = raycaster.intersectObjects(scene.children, true);
    if (intersects.length > 0) {
        const clickedObject = intersects[0].object;
        if (clickedObject.isSprite) {
            handleBubbleClick(clickedObject); // Panggil fungsi untuk menangani klik
        }
    }
});

// Pengaturan kamera dan kontrol
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.dampingFactor = 0.1;
controls.enablePan = false;

camera.position.set(75, 17, -6);
camera.lookAt(scene.position);

// Menangani resize layar
window.addEventListener('resize', function () {
    renderer.setSize(container.offsetWidth, container.offsetHeight);
    camera.aspect = container.offsetWidth / container.offsetHeight;
    camera.updateProjectionMatrix();
});

// Menambahkan event listener untuk klik
window.addEventListener('click', (event) => {
    // Normalisasi koordinat mouse
    const mouse = new THREE.Vector2();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    const raycaster = new THREE.Raycaster();
    raycaster.setFromCamera(mouse, camera);

    const intersects = raycaster.intersectObjects(scene.children, true);
    if (intersects.length > 0) {
        const clickedObject = intersects[0].object;
        if (clickedObject.isSprite) {
            handleBubbleClick(clickedObject);
        }
    }
});

// Mulai memuat pulau setelah halaman dimuat
loadIsland();

// Fungsi render untuk animasi
function animate() {
    requestAnimationFrame(animate);
    controls.update(); // Update kontrol kamera
    renderer.render(scene, camera);
}

animate();

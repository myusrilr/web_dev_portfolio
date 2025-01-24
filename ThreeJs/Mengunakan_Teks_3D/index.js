import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

// Membuat Scene, Kamera, dan Renderer
var scene = new THREE.Scene();
var cam = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 1000);
var renderer = new THREE.WebGLRenderer({ antialias: true });

renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

cam.position.z = 45;
cam.position.y = 3;

//cahaya 1
var hemi = new  THREE.HemisphereLight(0xffffff, 0xff00ff, 0.52);
scene.add(hemi);

//cahaya 2
var light = new THREE.PointLight({color:"white"});
light.position.y=5;
scene.add(light);

//cahaya 3
var light2 = new THREE.PointLight({color:"yellow"});
light.position.y=-5;
light.position.y=15;
scene.add(light2);

let grid = new THREE.GridHelper(100, 20, 0xfafafa, 0xfafafa);
grid.position.y=-0.5;
scene.add(grid)

// Orbit Controls
let controls = new OrbitControls(cam, renderer.domElement);

let selectedFont;

let loader = new THREE.FontLoader().load() 

function update() {
    requestAnimationFrame(update);
    renderer.render(scene, cam);
}

update();
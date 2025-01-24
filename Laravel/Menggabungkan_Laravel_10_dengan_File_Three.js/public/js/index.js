import * as THREE from 'three';

var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
camera.position.z = 80;

const geometry = new THREE.CylinderGeometry(5, 5, 20, 32);
const material = new THREE.MeshBasicMaterial({ color: 0x00ff00 });
const cylinder = new THREE.Mesh(geometry, material);
scene.add(cylinder);

var renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

window.addEventListener('resize', function () {
    renderer.setSize(window.innerWidth, window.innerHeight);
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
});

function draw() {
    requestAnimationFrame(draw);
    cylinder.rotation.y += 0.01;
    cylinder.rotation.x += 0.01;
    cylinder.rotation.z += 0.01;
    renderer.render(scene, camera);
}
draw();
import * as THREE from 'three';

var scene = new THREE.Scene();
var cam = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 100);
var renderer = new THREE.WebGLRenderer({ antialias: true });

scene.background = new THREE.Color(0xffffff);  // Warna latar belakang putih
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.BasicShadowMap;
cam.position.z += 7;  // Set kamera pada jarak 15 di sepanjang sumbu z
document.body.appendChild(renderer.domElement);

// Membuat kubus dengan warna merah
var box = new THREE.BoxGeometry(1, 1, 1);
var boxMat2 = new THREE.MeshPhongMaterial({
    color: 0xff0000,  // Warna kubus merah
});
var cube2 = new THREE.Mesh(box, boxMat2);
cube2.castShadow = true;
cube2.castShadow = true;
scene.add(cube2);

// Membuat plane dengan warna hijau
var plane = new THREE.PlaneGeometry(1000, 1000, 500, 500);
var planeMaterial = new THREE.MeshLambertMaterial({
    color: 0xaaffaa,  // Warna plane hijau
});
var planeMesh = new THREE.Mesh(plane, planeMaterial);
planeMesh.receiveShadow = true;  // Menerima cahaya pada plane
planeMesh.rotation.x = -Math.PI / 2;  // Rotasi plane agar sejajar dengan sumbu X-Z
planeMesh.position.y = -1;  // Geser sedikit di bawah kubus
scene.add(planeMesh);

//cahaya1
const light = new THREE.AmbientLight(0x404040);
//ambien light itu sebuah cahaya yang merata ditambahkan ke seluruh wilayah di dalam scene kita
scene.add(light);

//cahaya2
var pointLight = new THREE.PointLight(0xff0000, 30, 50);
// warnannya merah. intensitas : seberapa terang cahanya dengan defaultnya 1. distance = seberapa jauh cahanya bisa menyebar dan defaultnya adalah 0 limit. decay = semakin jauh, maka cahaya akan berkurang dan defaultnya adalah 1.
pointLight.position.set(0, 2, 2);
scene.add(pointLight);
scene.add(new THREE.PointLightHelper(pointLight, 0.2, 0x00ff00));
// ngasih tau letak pemancar cahaya point light

//cahaya3
// const hemi = new THREE.HemisphereLight(0x0000ff, 0x000000, 0.5);
// //bisa mengandung warna tanah dan langit. kayak ambien light, jadi bisa global
// scene.add(hemi);

// //cahaya4
// var directionalLight = new THREE.DirectionalLight(0x00ff00, 1);
// //warna merah, intensitas 0.5. directional light itu sebuah cahaya yang mengarah ke sebuah arah tertentu. kaayk ambient juga secara global
// directionalLight.position.set(2, 2, 0);
// directionalLight.target.position.set(3, 2, 0);
// directionalLight.target.updateMatrixWorld();
// scene.add(directionalLight);
// scene.add(new THREE.DirectionalLightHelper(directionalLight, 0.2, 0x00ff00));
// //ngasih tau letak pemancar cahaya directional light

//cahaya5
var spotLight = new THREE.SpotLight(0x0000ff, 100, 5, Math.PI / 5);
//warna biru, intensitas 100, distance 5, coneAngle = seberapa besar cahaya yang akan mengelilingi objek. defaultnya adalah Math.PI / 3(Math.PI=180). penumbangan = seberapa besar cahaya yang akan mengelilingi objek. defaultnya adalah 1.

spotLight.position.set(2, 2, 0);
// spotLight.target.position.set(3, 2, 0);
// spotLight.target.updateMatrixWorld();
spotLight.castShadow = true;
scene.add(spotLight);
scene.add(new THREE.SpotLightHelper(spotLight));








function draw() {
    requestAnimationFrame(draw);
    cube2.rotation.x += 0.01;
    cube2.rotation.z += 0.01;
    renderer.render(scene, cam);
}

draw();

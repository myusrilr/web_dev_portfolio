import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { FirstPersonControls } from 'three/addons/controls/FirstPersonControls.js';
import { TrackballControls } from 'three/addons/controls/TrackballControls.js';

let scene = new THREE.Scene();
let cam = new THREE.PerspectiveCamera(
    45,
    window.innerWidth / window.innerHeight,
    1,
    1000);
cam.position.z += 5;
scene.background = new THREE.Color(0x0a0a0a);
let renderer = new THREE.WebGLRenderer();

renderer.setSize(window.innerWidth, window.innerHeight); document.body.appendChild(renderer.domElement);

let cGeo = new THREE.BoxGeometry(1, 1, 1);
let cMat = new THREE.MeshBasicMaterial({ color: 0xff0000 });
let cMesh = new THREE.Mesh(cGeo, cMat);
scene.add(cMesh);

let planeGeo = new THREE.PlaneGeometry(100, 100);
let PlaneMesh = new THREE.Mesh(planeGeo, new THREE.MeshBasicMaterial({ color: 0xffffff }));
PlaneMesh.rotation.x -= Math.PI / 2;
PlaneMesh.position.y -= 0.5;
scene.add(PlaneMesh);




// //menggerakkan kamera secara manual, bisa menggunakan tombol keyboard maupun pakai gerakan mouse
// //1.menggerakkan kamera dengan tombol keyboard a,w,s,d, namun hanya mengatasi satu key saja saat tombolnya ditekan. sehingga pergerakannya menjadi lurus tidak bisa serong
// document.body.onkeydown = function (evt) {
//     if (evt.key == 'a') {
//         cam.position.x += 0.1;
//     } else if (evt.key == 'd') {
//         cam.position.x -= 0.1;
//     } if (evt.key == 'w') {
//         cam.position.y -= 0.1;
//     } else if (evt.key == 's') {
//         cam.position.y += 0.1;

//     };
// }

// //2.menggerakkan dengan tombol keyboard a,w,s,d lebih leluasa dan bisa serong
// let keyboard = [];
// document.body.onkeydown = function (evt) {
//     keyboard[evt.key] = true;
// }
// document.body.onkeyup = function (evt) {
//     keyboard[evt.key] = false;
// }

// function process_keyboard() {
//     if (keyboard['a']) {
//         cam.position.x += 0.03;
//     } else if (keyboard['d']) {
//         cam.position.x -= 0.03;
//     } if (keyboard['w']) {
//     //kalau ditulis if else juga, maka tidak akan bisa menciptakan gerakan kombinasinya
//         cam.position.y -= 0.03;
//     } else if (keyboard['s']) {
//         cam.position.y += 0.03;

//     };
// }

//controls built-in
//1.  OrbitControls
// const controls = new OrbitControls( cam, renderer.domElement );
//menggerakkan kamera dengan mouse. bisa dengan zoom-in/zoom-out nya dengan menekan ctrl + scroll mouse


// //2. FirstPersonControls
// //perbedaan antara orbitcontrols dan firstpersoncontrols adalah orbitcontrols membutuhkan clock (waktu pemanggilan terakhir update dan sekarang). cara mengoperasikannya kayak main game di counter strike, jadi kita tinggal ngarahin mousenya ke arah mana yang kita tuju. untuk zoom-in kita tekan lama klik kirinya, sedangkan untuk zoom-out kita tekan lama klik kananya.
let clock = new THREE.Clock();
// let controls = new FirstPersonControls(cam, renderer.domElement);
// controls.lookSpeed = 0.1;

//3.pointerlockcontrols
//menempatkan mouse cursor kita tepat di tengah layar.cocok buat game 3D
// let controls = new THREE.PointerLockControls(cam, renderer.domElement);

//4.trackballcontrols
//hampir sama dengan orbit controls, tapi ini bisa melewati atas objek kita

let controls = new TrackballControls(cam, renderer.domElement);





function update() {
    controls.update(clock.getDelta());
    // process_keyboard();
    renderer.render(scene, cam);
    requestAnimationFrame(update);
}
update();
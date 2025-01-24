import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

let scene = new THREE.Scene();
let cam = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 1000);
cam.position.z += 7;
scene.background = new THREE.Color(0x0a0a0a);

let renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setPixelRatio(devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

let controls = new OrbitControls(cam, renderer.domElement);

let grid = new THREE.GridHelper(100, 100, 0x0a0a0a, 0x000000);
grid.position.set(0, -0.5, 0);
scene.add(grid);

let kendali = new Object();
kendali.x = 1;
kendali.y = 1;
kendali.z = 2;

let gui = new dat.GUI();
gui.add(kendali, 'x', -4, 4, 0.1);
gui.add(kendali, 'y', -4, 4);
gui.add(kendali, 'z', -4, 4)

let rayCast = new THREE.Raycaster();
let mouse = {};
let selected;
let arrow = new THREE.ArrowHelper(rayCast.ray.direction, cam.position, 10, 0xff0000);
scene.add(arrow);


addEventListener("mousedown", (e) => {
    mouse.x = (e.clientX / window.innerWidth) * 2 - 1;
    mouse.y = (e.clientY / window.innerHeight) * -2 + 1;
    // console.log(mouse);

    rayCast.setFromCamera(mouse, cam);
    let items = rayCast.intersectObjects(scene.children);
    arrow.setDirection(rayCast.ray.direction);


    items.forEach((i) => {
        if (i.object.name != "") {
            // console.log(i.object.name);
            //mengecek khusus pada cube saja
            selected = i.object;
        }

    });
});



let pLight = new THREE.PointLight(0xffffff, 10);
pLight.position.set(1, 1, 2);
scene.add(pLight);
scene.add(new THREE.PointLightHelper(pLight, 0.1, 0xff0000));

let cGeo = new THREE.BoxGeometry(1, 1, 1);
let cMat = new THREE.MeshLambertMaterial({ color: 0xff0000 });
let cMesh = new THREE.Mesh(cGeo, cMat);
cMesh.position.set(2, 0, 0);
cMesh.name = "cube1";
scene.add(cMesh);

let cGeo2 = new THREE.BoxGeometry(1, 1, 1);
let cMat2 = new THREE.MeshLambertMaterial({ color: 0xff0000 });
let cMesh2 = new THREE.Mesh(cGeo2, cMat2);
cMesh2.position.set(-2, 0, 0);
cMesh2.scale.set(2, 1, 1);
cMesh2.name = "cube2";
scene.add(cMesh2);

let planeGeo = new THREE.PlaneGeometry(100, 100);
let planeMesh = new THREE.Mesh(planeGeo, new THREE.MeshBasicMaterial({ color: 0xffffff }));
planeMesh.rotation.x -= Math.PI / 2;
planeMesh.position.y -= 0.5;
scene.add(planeMesh);
let angle = 0;

function update() {
    if (selected != undefined) {
        selected.rotation.x += 0.01;
    }
    pLight.position.set(kendali.x, kendali.y, kendali.z);
    renderer.render(scene, cam);
    requestAnimationFrame(update);
}
update();

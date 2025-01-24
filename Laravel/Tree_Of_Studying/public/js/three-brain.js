import * as THREE from "https://cdn.skypack.dev/three@0.136.0";
import gsap from 'https://cdn.skypack.dev/gsap';
import { OrbitControls } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/controls/OrbitControls";
import { ImprovedNoise } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/math/ImprovedNoise";
import { Line2 } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/lines/Line2";
import { LineMaterial } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/lines/LineMaterial";
import { LineGeometry } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/lines/LineGeometry";
import { EffectComposer } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/postprocessing/EffectComposer.js";
import { RenderPass } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/postprocessing/RenderPass.js";
import { ShaderPass } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/postprocessing/ShaderPass.js";
import { UnrealBloomPass } from "https://cdn.skypack.dev/three@0.136.0/examples/jsm/postprocessing/UnrealBloomPass.js";

// Inisialisasi dan konfigurasi
const perlin = new ImprovedNoise();
let v3 = new THREE.Vector3();
var container = document.body;
var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera(45, container.offsetWidth / container.offsetHeight, 0.1, 1000);
var renderer = new THREE.WebGLRenderer();
renderer.toneMapping = THREE.ReinhardToneMapping;
renderer.setSize(container.offsetWidth, container.offsetHeight);
container.appendChild(renderer.domElement);
scene.background = new THREE.Color(0xC2FFC7);

// Fungsi untuk memuat data murid dan menampilkan bubble chat
async function fetchMuridData() {
    const response = await fetch('/api/users/murid');
    const muridData = await response.json();
    return muridData;
}

async function placeStudentBubbles(radius) {
    const murids = await fetchMuridData();
    murids.forEach((murid, index) => {
        const position = getRandomPointOnSphere(radius);
        createBubbleChat(murid.name, position);
    });
}

// Panggil fungsi ini setelah definisi untuk menempatkan bubble chat
placeStudentBubbles(4); // Contoh: Tambahkan bubble chat pada bola dengan radius 4



// brain creation
// <CURVE>

let curvePts = new Array(200).fill().map((p) => {
    return new THREE.Vector3().randomDirection();
});
let curve = new THREE.CatmullRomCurve3(curvePts, true);

let pts = curve.getSpacedPoints(200);
pts.shift();
curve = new THREE.CatmullRomCurve3(pts, true);
pts = curve.getSpacedPoints(10000);
pts.forEach((p) => {
    p.setLength(4);
});

let n = new THREE.Vector3();
let s = new THREE.Vector3(0.5, 0.5, 1);
pts.forEach((p) => {
    deform(p);
});

let fPts = [];
pts.forEach((p) => {
    fPts.push(p.x, p.y, p.z);
});

let g = new LineGeometry();
g.setPositions(fPts);
let globalUniforms = {
    time: { value: 0 },
    bloom: { value: 0 }
};
let m = new LineMaterial({
    color: 0x62825D,
    worldUnits: true,
    linewidth: 0.0375,
    alphaToCoverage: true,
    onBeforeCompile: (shader) => {
        shader.uniforms.time = globalUniforms.time;
        shader.uniforms.bloom = globalUniforms.bloom;
        shader.vertexShader = flVert;
        shader.fragmentShader = flFrag;
    }
});
m.resolution.set(innerWidth, innerHeight);
let l = new Line2(g, m);
l.computeLineDistances();
scene.add(l);
// </CURVE>

// <SPHERE>
let sg = new THREE.IcosahedronGeometry(1, 70);
for (let i = 0; i < sg.attributes.position.count; i++) {
    v3.fromBufferAttribute(sg.attributes.position, i);
    deform(v3);
    sg.attributes.position.setXYZ(i, v3.x, v3.y, v3.z);
}
let sm = new THREE.MeshBasicMaterial({
    color: 0x9EDF9C, // Warna hijau untuk kontras
    wireframe: false,
    transparent: false,
    onBeforeCompile: (shader) => {
        shader.uniforms.bloom = globalUniforms.bloom;
        shader.uniforms.time = globalUniforms.time;
        shader.vertexShader = `
      varying vec3 vN;
      ${shader.vertexShader}
    `.replace(
            `#include <begin_vertex>`,
            `#include <begin_vertex>
        vN = normal;
      `
        );
        //console.log(shader.vertexShader);
        shader.fragmentShader = `
      uniform float bloom;
      uniform float time;
      varying vec3 vN;
      ${noiseV3}
      ${shader.fragmentShader}
    `.replace(
            `#include <dithering_fragment>`,
            `#include <dithering_fragment>
        float ns = snoise(vec4(vN * 1.5, time * 0.5));
        ns = abs(ns);
        
        vec3 col = mix(diffuse, vec3(0, 1, 1) * 0.5, ns);
        
        gl_FragColor.rgb = mix(col, vec3(0), bloom);
        gl_FragColor.a = ns;
        gl_FragColor.rgb = mix(gl_FragColor.rgb, col, pow(ns, 16.));
      `
        );
    }
});
let sphere = new THREE.Mesh(sg, sm);
scene.add(sphere);
// </SPHERE>




// <LINKS>
let LINK_COUNT = 50;
let linkPts = [];
for (let i = 0; i < LINK_COUNT; i++) {
    let pS = new THREE.Vector3().randomDirection();
    let pE = new THREE.Vector3().randomDirection();
    let division = 100;
    for (let j = 0; j < division; j++) {
        let v1 = new THREE.Vector3().lerpVectors(pS, pE, j / division);
        let v2 = new THREE.Vector3().lerpVectors(pS, pE, (j + 1) / division);
        deform(v1, true);
        deform(v2, true);
        linkPts.push(v1, v2);
    }
}


let linkG = new THREE.BufferGeometry().setFromPoints(linkPts);
let linkM = new THREE.LineDashedMaterial({
    color: 0xC2FFC7,
    onBeforeCompile: (shader) => {
        shader.uniforms.time = globalUniforms.time;
        shader.uniforms.bloom = globalUniforms.bloom;
        shader.fragmentShader = `
      uniform float bloom;
      uniform float time;
      ${shader.fragmentShader}
    `
            .replace(
                `if ( mod( vLineDistance, totalSize ) > dashSize ) {
		discard;
	}`,
                ``
            )
            .replace(
                `#include <premultiplied_alpha_fragment>`,
                `#include <premultiplied_alpha_fragment>
        vec3 col = diffuse;
        gl_FragColor.rgb = mix(col * 0.5, vec3(0), bloom);
        
        float sig = sin((vLineDistance * 2. + time * 5.) * 0.5) * 0.5 + 0.5;
        sig = pow(sig, 16.);
        gl_FragColor.rgb = mix(gl_FragColor.rgb, col * 0.75, sig);
      `
            );
    }
});

renderer.render(scene, camera);


let link = new THREE.LineSegments(linkG, linkM);
link.computeLineDistances();
scene.add(link);
// </LINKS>

// <BLOOM>
const params = {
    exposure: 1,
    bloomStrength: 7,
    bloomThreshold: 0,
    bloomRadius: 0
};
const renderScene = new RenderPass(scene, camera);

const bloomPass = new UnrealBloomPass(
    new THREE.Vector2(window.innerWidth, window.innerHeight),
    1.5,
    0.4,
    0.85
);
bloomPass.threshold = params.bloomThreshold;
bloomPass.strength = params.bloomStrength;
bloomPass.radius = params.bloomRadius;

const bloomComposer = new EffectComposer(renderer);
bloomComposer.renderToScreen = false;
bloomComposer.addPass(renderScene);
bloomComposer.addPass(bloomPass);

const finalPass = new ShaderPass(
    new THREE.ShaderMaterial({
        uniforms: {
            baseTexture: { value: null },
            bloomTexture: { value: bloomComposer.renderTarget2.texture }
        },
        vertexShader: document.getElementById("vertexshader").textContent,
        fragmentShader: document.getElementById("fragmentshader").textContent,
        defines: {}
    }),
    "baseTexture"
);
finalPass.needsSwap = true;

const finalComposer = new EffectComposer(renderer);
finalComposer.addPass(renderScene);
finalComposer.addPass(finalPass);
// </BLOOM>

//buble-chat
function createBubbleTexture(text, width, height) {
    const scaleFactor = 2;  // Faktor skala untuk resolusi lebih tinggi
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    canvas.width = width * scaleFactor;
    canvas.height = height * scaleFactor;
    context.scale(scaleFactor, scaleFactor);

    // Background Bubble
    context.fillStyle = '#FFFFFF';  // Warna latar belakang
    context.strokeStyle = 'rgba(0, 0, 0, 0.5)';
    context.lineWidth = 3;

    // Rounded Rectangle
    const borderRadius = 15;
    const tailWidth = 10;
    const tailHeight = 15;
    const tailPosition = width - 60;

    // Draw rounded rectangle with tail
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
    context.fillStyle = '#526E48';  // Warna teks
    context.textAlign = 'center';
    context.textBaseline = 'middle';

    // Gambar teks
    context.fillText(text, width / 2, height / 2);

    // Convert to texture
    const texture = new THREE.CanvasTexture(canvas);
    texture.needsUpdate = true;

    return texture;
}

function handleBubbleClick() {
    // Arahkan ke halaman landing-island.blade.php
    window.location.href = '/guru/landing-island';
}



function createBubbleChat(text, position) {
    const texture = createBubbleTexture(text, 110, 55);

    const bubbleMaterial = new THREE.SpriteMaterial({
        map: texture,
        transparent: true,
    });

    const bubbleChat = new THREE.Sprite(bubbleMaterial);
    bubbleChat.scale.set(2, 1, 1);
    bubbleChat.position.copy(position);
    bubbleChat.userData.id = text; // Simpan ID bubble sebagai contoh

    bubbleChat.addEventListener('click', () => handleBubbleClick(bubbleChat));

    scene.add(bubbleChat);
    return bubbleChat;
}

// Raycaster dan mouse untuk deteksi klik
const raycaster = new THREE.Raycaster();
const mouse = new THREE.Vector2();

// Event listener untuk klik
window.addEventListener('click', (event) => {
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    raycaster.setFromCamera(mouse, camera);
    const intersects = raycaster.intersectObjects(scene.children, true);

    if (intersects.length > 0) {
        const clickedObject = intersects[0].object;

        // Jika objek yang diklik adalah bubble chat, tangani klik
        if (clickedObject.isSprite) {
            handleBubbleClick(clickedObject);
        }
    }
});


function getRandomPointOnSphere(radius) {
    const u = Math.random();
    const v = Math.random();
    const theta = 2 * Math.PI * u;
    const phi = Math.acos(2 * v - 1);

    const x = radius * Math.sin(phi) * Math.cos(theta);
    const y = radius * Math.sin(phi) * Math.sin(theta);
    const z = radius * Math.cos(phi);

    return new THREE.Vector3(x, y, z);
}

let clock = new THREE.Clock();

info.style.visibility = "hidden";
writing.style.visibility = "visible";

renderer.setAnimationLoop(() => {
    let t = clock.getElapsedTime();
    controls.update();
    globalUniforms.time.value = t;
    finalComposer.render();
});

function deform(p, useLength) {
    let mainR = 5;

    v3.copy(p).normalize();
    let len = p.length();

    let ns = perlin.noise(v3.x * 3, v3.y * 3, v3.z * 3);
    ns = Math.pow(Math.abs(ns), 0.5) * 0.25;

    let r = smoothstep(0.125, 0, Math.abs(v3.x)) - ns;
    p.setLength(mainR - Math.pow(r, 2) * 1);
    p.y *= 1 - 0.5 * smoothstep(0, -mainR, p.y);
    p.y *= 0.75;
    p.x *= 0.75;
    p.y *= 1 - 0.125 * smoothstep(mainR * 0.25, -mainR, p.z);
    p.x *= 1 - 0.125 * smoothstep(mainR * 0.25, -mainR, p.z);
    if (useLength) {
        p.multiplyScalar(len);
    }
    //p.y += 0.5;
}

//https://github.com/gre/smoothstep/blob/master/index.js
function smoothstep(min, max, value) {
    var x = Math.max(0, Math.min(1, (value - min) / (max - min)));
    return x * x * (3 - 2 * x);
}

// Add controls
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.dampingFactor = 0.1;
controls.enablePan = false;
controls.enableDamping = true;

// Position camera
camera.position.set(0, 1.5, 15); // Pastikan ini sesuai dengan kebutuhan
camera.lookAt(scene.position);

// Handle resize
window.addEventListener('resize', function () {
    renderer.setSize(container.offsetWidth, container.offsetHeight);
    camera.aspect = container.offsetWidth / container.offsetHeight;
    camera.updateProjectionMatrix();
    m.resolution.set(innerWidth, innerHeight);
    bloomPass.resolution.set(innerWidth, innerHeight);
});


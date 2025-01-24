import * as THREE from 'three';

let scene = new THREE.Scene();
let cam = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
let renderer = new THREE.WebGLRenderer({ antialias: true });// apa itu anti alias:true?


renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);

cam.position.z = 5;
//kamera menggunakan perspektif, jarak ini memungkinkan kita melihat objek di dalam scene dari kejauhan tertentu. Semakin besar nilai z, semakin jauh kamera dari objek, sehingga objek tampak lebih kecil. Sebaliknya, jika z memiliki nilai yang lebih kecil (misalnya 1 atau 2), objek akan tampak lebih besar, dan akhirnya akan mengisi layar jika nilainya sangat kecil.

const geo_saya = new THREE.BoxGeometry(1, 1, 1, 10, 10, 10);
const leaf_texture = new THREE.TextureLoader().load('./texture/leaf.jpg');
const A_texture = new THREE.TextureLoader().load('./texture/A.png');
const B_texture = new THREE.TextureLoader().load('./texture/B.png');
const C_texture = new THREE.TextureLoader().load('./texture/C.png');

const mat_array = [
    new THREE.MeshBasicMaterial({ map: A_texture }),
    new THREE.MeshBasicMaterial({ map: B_texture }),
    new THREE.MeshBasicMaterial({ map: C_texture }),
    new THREE.MeshBasicMaterial({ map: A_texture }),
    new THREE.MeshBasicMaterial({ map: B_texture }),
    new THREE.MeshBasicMaterial({ map: C_texture }),
];

// const alpha_texture = new THREE.TextureLoader().load('./texture/alpha_map.png');
// const brick_texture = new THREE.TextureLoader().load('./texture/brick.png');


let ambientLight = new THREE.AmbientLight(0xffffff, 0.3); // Cahaya rendah agar shininess terlihat
scene.add(ambientLight);

//cube1 dengan MeshBasicMaterial
const mat_saya = new THREE.MeshBasicMaterial({ map: leaf_texture, });
// ketika wireframe diubah menjadi true, maka akan menampilkan garis pada objek(objek kita jadi mirip tesseract kek di film loki). warna dihilankan agar tidak mengganggu warna aslinya dari gambar texture
let mesh_saya = new THREE.Mesh(geo_saya, mat_saya,);
scene.add(mesh_saya);

//persegi
const geo_2 = new THREE.BufferGeometry();
let vertices = new Float32Array([
    -1.0, -1.0, 0.0,
    1.0, -1.0, 0.0,
    1.0, 1.0, 0.0,

    1.0, 1.0, 0.0,
    -1.0, 1.0, 0.0,
    -1.0, -1.0, 0.0,
]);
let uvs = new Float32Array([
    0.2, 0.2,
    0.8, 0.2,
    1.0, 0.8,

    0.0, 0.0,
    1.0, 0.0,
    1.0, 1.0,
]);

geo_2.setAttribute('position', new THREE.BufferAttribute(vertices, 3));
geo_2.setAttribute('uv', new THREE.BufferAttribute(uvs, 2));
let material2 = new THREE.MeshBasicMaterial({
    color: 0xff0000,
    map: A_texture
    //kalau ingin menambahkan texture di buffer geometry, maka harus menambahkan UVnya

});
let mesh2 = new THREE.Mesh(geo_2, material2);
mesh2.position.set(-2, 0, 0);
scene.add(mesh2);


//cube2 dengan MeshLambertMaterial
//lighting dari atas
// let light1 = new THREE.DirectionalLight(0xffffff, 1);
// light1.position.set(0, 3, 2);
// scene.add(light1);

// //lighting dari bawah
// let light2 = new THREE.DirectionalLight(0xffffff, 1);
// light2.position.set(0, -3, 2);
// scene.add(light2);


// const mat_saya2 = new THREE.MeshLambertMaterial({
//     map: leaf_texture,
//     // emissive: 0x00ff00,
//     //Warna emisif (cahaya) bahan, pada dasarnya adalah warna solid yang tidak terpengaruh oleh pencahayaan lain. Standarnya adalah hitam.
//     // emissiveIntensity: 1,
//     //Intensitas emisif(cahaya yang dipancarkan). Standarnya adalah 1.
//     // emissiveMap: alpha_texture,
//     //Mengatur peta emisif (cahaya). Nilai default adalah nol. Warna peta emisif dimodulasi/dimodifikasi oleh warna emisif dan intensitas emisif
//     alphaMap: alpha_texture,
//     //Mengatur peta alpha. Nilai default adalah nol.
//     transparent: true,
//     //Mengatur apakah objek ini transparan. Nilai default adalah false.
//     side: THREE.DoubleSide,
//     //Mengatur sisi mana yang akan dibentuk. Jadi, kotaknya akan benar-benar transparent.

// });
// //Mesh ini bisa dikasih lighting dan defaultnya gelap. lebih banyak propertinya, jaid bisa otak-atik daripada yang basic.
// let mesh_saya2 = new THREE.Mesh(geo_saya, mat_saya2,);
// mesh_saya2.position.set(2, 0, 0);//mengatur bentuk ke dua berada di sumbu x ke2, jadi berada di sebelah kanannnya
// scene.add(mesh_saya2);

// //cube3 dengan MeshPhongMaterial
// const mat_saya3 = new THREE.MeshPhongMaterial({
//     map: leaf_texture,
//     shininess: 100,
//     //Mengatur ketebalan cahaya. Nilai default adalah 30.
//     // bumpMap: brick_texture,
//     //menambah detail tanpa nambah vertexnya. seolah-olah ada bagian yang maju dan mundur
//     // bumpScale: 1
//     //mengatur tingkat skala efek bumpping. Nilai default adalah 1.
//     displacementMap: brick_texture,
//     //hampir sama dengan bumpmap, tapi ini jauh lebih ekstrim. displacement (mengubah bentuk)
//     displacementScale : 0.1,
//     //mengatur tingkat skala efek displacement. Nilai default adalah 1.

// });
// let mesh_saya3 = new THREE.Mesh(geo_saya, mat_saya3,);
// mesh_saya3.position.set(-2, 0, 0);
// scene.add(mesh_saya3);


window.addEventListener('resize', function () {
    var width = window.innerWidth;
    var height = window.innerHeight;
    renderer.setSize(width, height);
    cam.aspect = width / height;
    cam.updateProjectionMatrix();
});

function draw() {
    requestAnimationFrame(draw);
    //cube1
    mesh_saya.rotation.y += 0.01;
    mesh_saya.rotation.x += 0.01;

    // //cube2
    // mesh_saya2.rotation.y += 0.01;
    // mesh_saya2.rotation.x += 0.01;

    // //cube3
    // mesh_saya3.rotation.y += 0.01;
    // mesh_saya3.rotation.x += 0.01;

    renderer.render(scene, cam);
}
draw();
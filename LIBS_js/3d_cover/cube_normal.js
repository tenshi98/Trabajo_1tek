//create the scene
var scene = new THREE.Scene();
var container = document.getElementById('cover_prod'); 
//create the camera   (field of view, aspect ratio, far clipping plane, )
var camera = new THREE.PerspectiveCamera( 42, container.offsetWidth / container.offsetHeight, 0.1, 1000 );

//create the renderer
var renderer = new THREE.WebGLRenderer();

var w = container.offsetWidth;
var h = container.offsetHeight/2;
renderer.setSize(w, h);
renderer.setClearColor(0xFFFFFF, 1);
container.appendChild(renderer.domElement);
 
/* ---------- Add a cube --------------*/
 
//add the geometry, this is an object that contains all the verticies and faces. pass in the size of the faces
var geometry = new THREE.CubeGeometry(med_ancho,med_alto,med_largo);
 
//create the texture by loading our image from file
//var texture = THREE.TextureLoader().load( textura );
var texture = new THREE.TextureLoader().load(textura );
 
//set quality of the texture when it is viewed on a perspective (not essential)
texture.anisotropy = renderer.capabilities.getMaxAnisotropy();
 
var material = new THREE.MeshBasicMaterial( { map: texture } );
 
//create the Mesh using the geometry and material
var cube = new THREE.Mesh( geometry, material );
 
//add the cube to the scene, defaults to coords 0,0,0 (x,y,z)
scene.add( cube );
 
//move the camera back a bit so it is not sitting on the cube, if you see a white canvas try adjusting the camera pos
camera.position.z = 20;
 
/* ---- Render Loop ---- */
function render()
{
//use requestAnimmationFrame instead of SetInterval
 requestAnimationFrame(render);
 
 //update cube rotation
 //cube.rotation.x += 0.01;
 cube.rotation.y += 0.005;
 
 //render
 renderer.render(scene, camera);
}
 
//start the render loop
render();

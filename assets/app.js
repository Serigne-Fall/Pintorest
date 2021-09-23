/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
//jquery popper.js
import $ from 'jquery';
// any CSS you import will output into a single css file (app.css in this case)
import './scss/app.scss';
// start the Stimulus application
import './bootstrap';

document.querySelector(".custom-file-input").addEventListener('change',function(e){
    console.log(e.currentTarget);
    let inputFile=e.currentTarget;
    console.log(inputFile.files[0].name)
    document.querySelector('.custom-file-label').innerHTML=inputFile.files[0].name;
});
// $('.custom-file-input').on('change',function(){
//     alert("changement");
// })
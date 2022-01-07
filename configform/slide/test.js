var exports = {};
jQuery(document).ready(function() {
  var splide = new Splide( '.splide' );
  splide.mount();
    alert("mount valid");
});

Drupal.behaviors.mySlide = {
  _flag: true,
  attach: function (context, settings) {
    if(this._flag == false) {return 0;}
    this._flag = false;
    console.log("mySlide");

    console.log(context);
    console.log(settings.myvar);

    jQuery('h1.page-title',context).click(function(){
      alert("ciao");
    });





    //Using once() to apply the myCustomBehaviour effect when you want to run just one function.
/*
    once('mySlide', , context).click(function (element) {
      alert("click");
      console.log(element);
    //  element.classList.add('processed');
    });
*/
/*
    jQuery('h1.page-title', context).once('click', function (e) {
      console.log(e);
         // Code here will only be applied to $('#some_element')
         // a single time.
    });
*/
  }
};
/*
document.addEventListener( 'DOMContentLoaded', function() {


} );
*/

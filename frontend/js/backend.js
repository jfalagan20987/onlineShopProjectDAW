const productList = document.querySelector('.productList');
const allProducts = productList.innerHTML;

function showSearch(str){
  if(str.length == 0){
    productList.innerHTML = allProducts;
    return;
  }else{
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function (){
      if (this.readyState == 4 && this.status == 200){
        productList.innerHTML = "";
        productList.innerHTML = this.responseText;
      }
    }
  };

  httpRequest.open("GET", "products.php?param=" + str, true);
  httpRequest.send();
}
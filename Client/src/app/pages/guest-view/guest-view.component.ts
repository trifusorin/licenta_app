import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { HttpGenericService } from 'src/app/services/http-generic-service';

@Component({
  selector: 'app-guest-view',
  templateUrl: './guest-view.component.html',
  styleUrls: ['./guest-view.component.css']
})
export class GuestViewComponent implements OnInit {

  constructor(private router: Router, private httpService: HttpGenericService<any>) { }

  tableRandomCode:string = "";

  tableLoaded:boolean = false;
  productsLoaded: boolean = false;

  newOrder:any = {"title": "", "description": ""};
  addedProducts: any[] = [];
  totalPrice: number = 0;
  
  table: any = {};
  products: any[] = []

  ngOnInit(): void {
    this.loadProducts();
  }

  loadProducts(){
    this.httpService.get("products/list").subscribe(resp=>{
      this.products = resp;
      this.productsLoaded = true;
    })
  }

  submitRandomCode(){
    this.searchTableByCode(this.tableRandomCode);
  }



  searchTableByCode(code:string){
    this.httpService.get("tables/getByRandomCode/" + code).subscribe(resp=>{
      this.table = resp;
      if(this.table.status != "closed"){
        this.table = resp;
        this.tableLoaded = true;
      }else{
        this.table = {};
      }
    })
  }

  submitNewOrder(){
    let newOrder = this.newOrder;
    newOrder.tableId  =this.table.id;
    newOrder.price = 0;
    newOrder.orderedProducts = [];
    this.addedProducts.forEach(addedProduct =>{
      newOrder.price += Number(addedProduct.price);
      newOrder.orderedProducts.push({"productId": addedProduct.id}) ;
    })

    this.httpService.post("orders/add/", newOrder).subscribe(resp=>{
      this.tableLoaded = false;

      this.newOrder = {"title": "", "description": ""};
      this.addedProducts = [];
      this.totalPrice = 0;

      this.searchTableByCode(this.tableRandomCode);


    })
  }


  addProductInList(product: any){
    this.addedProducts.push(product);
    this.calculateTotalPrice();
  }

  removeProductFromList(product: any){

   // this.addedProducts = this.arrayRemove(this.addedProducts, product);

   for(let i = 0; i < this.addedProducts.length; i++){
    if(this.addedProducts[i] == product){
      this.addedProducts[i] = null;
      i = this.addedProducts.length;
    }
   }
   this.addedProducts = this.arrayRemove(this.addedProducts, null);
   this.calculateTotalPrice();
  }



  arrayRemove(arr:any[], value:any) { 
    
    return arr.filter(function(ele){ 
        return ele != value; 
    });
  }

  calculateTotalPrice(){
    this.totalPrice = 0;
    this.addedProducts.forEach(product => {
      this.totalPrice += Number(product.price);
    })
  }

}

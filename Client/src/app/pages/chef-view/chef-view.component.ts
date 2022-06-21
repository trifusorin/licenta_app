import { Component, OnInit } from '@angular/core';
import { HttpGenericService } from 'src/app/services/http-generic-service';
import { Router } from '@angular/router';



@Component({
  selector: 'app-chef-view',
  templateUrl: './chef-view.component.html',
  styleUrls: ['./chef-view.component.css']
})
export class ChefViewComponent implements OnInit {

  constructor(private router: Router, private httpService: HttpGenericService<any>) { }

  orders: any[] = [];
  closedOrders: any[] = [];
  openOrders: any[] = [];


  products: any = [];

  loaded: boolean = false;

  ngOnInit(): void {
    this.loadOrders();
  }


  loadOrders(){
    this.httpService.get("orders/list").subscribe(resp =>{
      this.orders = resp;
      this.sortOrdersByStatus(resp);
      this.loaded = true;
    })
  }

  closeOrder(id: number){
    this.httpService.get("orders/close/" + id).subscribe(resp =>{
      this.loaded = false;
      this.loadOrders();
    })
  }

  sortOrdersByStatus(orders: any[]){
    orders = this.orderOrdersByDate(orders);
    this.closedOrders = [];
    this.openOrders = [];

    orders.forEach(order => {
        if(order.status == "closed"){
          this.closedOrders.push(order);
        }else{
          this.openOrders.push(order);
        }
    });

    this.closedOrders = this.orderOrdersByDate(this.closedOrders, false);
    this.openOrders = this.orderOrdersByDate(this.openOrders, true);
  }

  orderOrdersByDate(orders: any[], asc:boolean = true): any[]{
    if(asc){
      orders.sort((a,b) => Date.parse(a.created) - Date.parse(b.created))
    }else{
      orders.sort((a,b) => Date.parse(b.created) - Date.parse(a.created))
    }

    return orders;
  }

}

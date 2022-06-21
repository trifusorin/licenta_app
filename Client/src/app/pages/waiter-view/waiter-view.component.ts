import { Component, OnInit } from '@angular/core';
import { HttpGenericService } from 'src/app/services/http-generic-service';
import { Router } from '@angular/router';
import { FormControl, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-waiter-view',
  templateUrl: './waiter-view.component.html',
  styleUrls: ['./waiter-view.component.css']
})
export class WaiterViewComponent implements OnInit {

  constructor(private router: Router, private httpService: HttpGenericService<any>) { }

  tables: any[] = [];

  closedTables: any[] = [];
  openTables: any[] = [];


  products: any = [];

  loaded: boolean = false;

  newTable = {"name": "", "description": ""};

  newTableForm = new FormGroup({
    name: new FormControl(''),
    description: new FormControl(''),
  });

  ngOnInit(): void {
    this.loadTables();
  }


  loadTables(){
    this.httpService.get("tables/list").subscribe(resp =>{
      this.tables = resp;
      this.sortTablesByStatus(resp);
      this.loaded = true;
    })
  }


  sortTablesByStatus(tables: any[]){
    tables = this.orderRecordsByDate(tables, "created", true);
    this.closedTables = [];
    this.openTables = [];

    tables.forEach(table => {
        if(table.status == "closed"){
          this.closedTables.push(table);
        }else{
          this.openTables.push(table);
        }
    });

    this.closedTables = this.orderRecordsByDate(this.closedTables, "created", true);
    this.openTables = this.orderRecordsByDate(this.openTables, "created", false);
  }

  closeOrder(id: number){
    this.httpService.get("orders/close/" + id).subscribe(resp =>{
      this.loaded = false;
      this.loadTables();
    })
  }

  closeTable(id: number){
    this.httpService.get("tables/close/" + id).subscribe(resp =>{
      this.loaded = false;
      this.loadTables();
    })
  }



  orderRecordsByDate(record: any[], dateFieldKey: string, asc:boolean = true): any[]{
    if(asc){
      record.sort((a,b) => Date.parse(a[dateFieldKey]) - Date.parse(b[dateFieldKey]))
    }else{
      record.sort((a,b) => Date.parse(b[dateFieldKey]) - Date.parse(a[dateFieldKey]))
    }

    return record;
  }

  onSubmitNewTable(){
    let newRecord = this.newTable;
    this.httpService.post("tables/add",newRecord).subscribe(resp =>{
        console.log(resp);
        location.reload();
    });
  }


}

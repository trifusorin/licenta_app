import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ChefViewComponent } from './pages/chef-view/chef-view.component';
import { GuestViewComponent } from './pages/guest-view/guest-view.component';
import { HomeComponent } from './pages/home/home.component';
import { WaiterViewComponent } from './pages/waiter-view/waiter-view.component';

const routes: Routes = [
  { path: 'login', component: HomeComponent },
  { path: 'bucatarie', component: ChefViewComponent },
  { path: 'client', component: GuestViewComponent },
  { path: 'bar', component: WaiterViewComponent },

  { path: '**', redirectTo: 'home' } // 404
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

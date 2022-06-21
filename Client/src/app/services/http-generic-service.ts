import { HttpClient, HttpHeaders, HttpResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})

export class HttpGenericService<T>{

  baseUrl: string = "http://localhost/index.php/"; //"http://ls.aditenea.net/index.php/";  //"http://localhost/index.php/";

  header = {
    headers: new HttpHeaders()
      //.set('Authorization', `Bearer ${localStorage.getItem('token')}`)
      //.set('Access-Control-Allow-Origin', `*`)
      //.set('Access-Control-Allow-Methods', `GET, POST`)
      //.set('Access-Control-Allow-Headers', `X-Requested-With`)
  }


  constructor(private http: HttpClient) {
  }

  get(urlExtension: string): Observable<T[]> {
    console.log(this.baseUrl + urlExtension);
    return this.http.get<T[]>(this.baseUrl + urlExtension, this.header);
  }

  getById(urlExtension: string, id: number): Observable<T> {
    return this.http.get<T>(this.baseUrl + urlExtension + "/" + id, this.header);
  }

  post(urlExtension: string, t: T): Observable<T> {
    console.log(this.header);
    return this.http.post<T>(this.baseUrl + urlExtension, t, this.header);
  }

  put(urlExtension: string, t: T, id: number): Observable<T> {
    return this.http.put<T>(this.baseUrl + urlExtension + "/" + id, t, this.header);
  }

  delete(urlExtension: string, id: number): Observable<T> {
    return this.http.delete<T>(this.baseUrl + urlExtension + "/" + id, this.header);
  }
}

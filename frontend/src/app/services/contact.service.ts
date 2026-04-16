import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Contact {
  id_contact?: number;
  first_name: string;
  last_name: string;
  email?: string;
  phone?:string;
  status?: string;
}

@Injectable({ providedIn: 'root' })
export class ContactService {

  private apiUrl = 'http://localhost:8000/api/contacts';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Contact[]> {
    return this.http.get<Contact[]>(this.apiUrl);
  }

  create(contact: Contact): Observable<any> {
    return this.http.post(this.apiUrl, contact);
  }

  update(id: number, contact: Contact): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}`, contact);
  }

  delete(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }
}
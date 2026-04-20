import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Company {
  id_company?: number;
  name: string;
  secteur: string;
  email?: string;
  phone?:string;
  adress?: string;
}

@Injectable({ providedIn: 'root' })
export class CompanyService {

  private apiUrl = 'http://localhost:8000/api/companies';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Company[]> {
    return this.http.get<Company[]>(this.apiUrl);
  }

  create(company: Company): Observable<any> {
    return this.http.post(this.apiUrl, company);
  }

  update(id: number, company: Company): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}`, company);
  }

  delete(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }
}
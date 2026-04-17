import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Deal {
  id_deal?: number;
  name: string;
  amount: number;

  id_contact: number;
  id_company?: number;
  date?: string;
  status?: string;
}

@Injectable({ providedIn: 'root' })
export class DealService {

  private apiUrl = 'http://localhost:8000/api/deals';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Deal[]> {
    return this.http.get<Deal[]>(this.apiUrl);
  }

  create(deal: Deal): Observable<any> {
    return this.http.post(this.apiUrl, deal);
  }

  update(id: number, deal: Deal): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}`, deal);
  }

  delete(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }
}
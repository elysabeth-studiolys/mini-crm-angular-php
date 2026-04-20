import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Project {
  id_project?: number;
  name: string;
  description: string;

  contact_name?: string;
  company_name?:string;
  status?: string;
  price?: number;
  date?: string;
}

@Injectable({ providedIn: 'root' })
export class ProjectService {

  private apiUrl = 'http://localhost:8000/api/projects';

  constructor(private http: HttpClient) {}

  getAll(): Observable<Project[]> {
    return this.http.get<Project[]>(this.apiUrl);
  }

  create(project: Project): Observable<any> {
    return this.http.post(this.apiUrl, project);
  }

  update(id: number, project: Project): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}`, project);
  }

  delete(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/${id}`);
  }
}
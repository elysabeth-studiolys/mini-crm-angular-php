import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Company, CompanyService } from '../../services/company.service';
import { LucideAngularModule } from 'lucide-angular';

import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-companies',
  standalone: true,
  imports: [CommonModule, LucideAngularModule, FormsModule],
  templateUrl: './companies.html',
  styleUrl: './companies.scss',
})


export class CompaniesComponent implements OnInit {

  companies: Company[] = [];

  constructor(
    private companyService: CompanyService,
    private cdr: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    this.companyService.getAll().subscribe(data => {
      console.log(data);
      this.companies = data;
      this.cdr.detectChanges(); //FORCE LA MISE A JOUR DONNÉE APRES REFRESH
    },
    error => {
      console.error('Error API:', error);
    });
  }

  delete(id: number): void {
    this.companyService.delete(id).subscribe(() => {
      this.companies = this.companies.filter(c => c.id_company !== id);
    })
  }

  //FORMULAIRE ADD CONTACT

  showForm = false;
  newCompany: Company = {
    name: '',
    secteur: '',
    email: '',
    phone: '',
    adress: ''
  };

  create(): void {
    this.companyService.create(this.newCompany).subscribe({
      next: () => {
        this.companyService.getAll().subscribe(data => {
          this.companies = data;
          this.cdr.detectChanges();
        });
        this.showForm = false;
        this.newCompany = {
          name: '',
          secteur: '',
          email: '',
          phone: '',
          adress: ''
        };
      },
      error: err => console.error('erreur création:', err)
    })
  }
}

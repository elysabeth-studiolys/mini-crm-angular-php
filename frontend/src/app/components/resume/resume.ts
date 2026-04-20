import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { Contact, ContactService } from '../../services/contact.service';
import { Company, CompanyService } from '../../services/company.service';
import { Deal, DealService } from '../../services/deal.service';
import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-resume',
  imports: [ CommonModule ],
  templateUrl: './resume.html',
  styleUrl: './resume.scss',
})
export class ResumeComponent {
  contacts: Contact[] = [];
  companies: Company[] = [];
  deals: Deal[] = [];

  constructor(
    private contactService: ContactService,
    private cdr: ChangeDetectorRef,
    private companyService: CompanyService,
    private dealService: DealService,

  ) {}
    totalDeals = 0

  ngOnInit(): void {
    this.contactService.getAll().subscribe(data => {
      console.log(data);
      this.contacts = data;
      this.cdr.detectChanges(); //FORCE LA MISE A JOUR DONNÉE APRES REFRESH
    },
    error => {
      console.error('Error API:', error);
    });
    this.companyService.getAll().subscribe(data => {
      console.log(data);
      this.companies = data;
      this.cdr.detectChanges(); //FORCE LA MISE A JOUR DONNÉE APRES REFRESH
    },
    error => {
      console.error('Error API:', error);
    });
    this.dealService.getAll().subscribe(data => {
      console.log(data);
      this.deals = data;
      this.totalDeals = this.dealService.getTotalAmount(data);
      this.cdr.detectChanges(); //FORCE LA MISE A JOUR DONNÉE APRES REFRESH
    },
    error => {
      console.error('Error API:', error);
    });
  }

  

}

import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { Contact, ContactService } from '../../services/contact.service';
import { Company, CompanyService } from '../../services/company.service';


@Component({
  selector: 'app-resume',
  imports: [],
  templateUrl: './resume.html',
  styleUrl: './resume.scss',
})
export class ResumeComponent {
  contacts: Contact[] = [];
  companies: Company[] = [];

  constructor(
    private contactService: ContactService,
    private cdr: ChangeDetectorRef,
    private companyService: CompanyService,
  ) {}

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
  }

  

}

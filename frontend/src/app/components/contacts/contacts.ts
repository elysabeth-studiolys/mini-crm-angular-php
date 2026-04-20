import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Contact, ContactService } from '../../services/contact.service';
import { LucideAngularModule } from 'lucide-angular';

import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-contacts',
  standalone: true,
  imports: [CommonModule, LucideAngularModule, FormsModule],
  templateUrl: './contacts.html',
  styleUrl: './contacts.scss',
})


export class ContactsComponent implements OnInit {

  contacts: Contact[] = [];

  constructor(
    private contactService: ContactService,
    private cdr: ChangeDetectorRef
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
  }

  delete(id: number): void {
    this.contactService.delete(id).subscribe(() => {
      this.contacts = this.contacts.filter(c => c.id_contact !== id);
    })
  }

  //FORMULAIRE ADD CONTACT // modifier

  
  

  showForm = false;
  editingContact: Contact | null = null;
  formContact: Contact = {
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    status: ''
  };

  openEdit(contact: Contact) : void {
    this.editingContact = { ...contact };
    this.formContact = { ...contact };
    this.showForm = true;
  }


  create(): void {
    this.contactService.create(this.formContact).subscribe({
      next: () => {
        this.contactService.getAll().subscribe(data => {
          this.contacts = data;
          this.cdr.detectChanges();
        });
        this.resetForm();
      },
      error: err => console.error('erreur création:', err)
    });
  }
  update(): void {
    if (!this.editingContact?.id_contact) return;
    this.contactService.update(this.editingContact.id_contact, this.formContact).subscribe({
      next: () => {
      this.contactService.getAll().subscribe(data => {
        this.contacts = data;
        this.cdr.detectChanges();
      });
      this.resetForm();
      },
      error: err => console.error('Erreur changement', err)
    });
  }

  resetForm(): void {
    this.formContact = { first_name: '', last_name: '', email: '', phone: '', status: ''};
    this.editingContact = null;
    this.showForm = false;
  }

}

import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';

import { ContactsComponent } from './components/contacts/contacts';
import { CompaniesComponent } from './components/companies/companies';


@Component({
  selector: 'app-root',
  imports: [RouterOutlet, ContactsComponent, CompaniesComponent],
  templateUrl: './app.html',
  styleUrl: './app.scss'
})
export class App {
  protected readonly title = signal('mini-crm-front');
}

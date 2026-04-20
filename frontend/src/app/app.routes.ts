import { Routes } from '@angular/router';
import { ResumeComponent } from '../app/components/resume/resume';
import { ContactsComponent } from '../app/components/contacts/contacts';
import { CompaniesComponent } from '../app/components/companies/companies';
import { DealsComponent } from '../app/components/deals/deals';

export const routes: Routes = [
    { path: '', component:ResumeComponent},
    { path: 'contacts', component:ContactsComponent},
    { path: '', component:CompaniesComponent},
    { path: 'deals', component:DealsComponent },
   
];

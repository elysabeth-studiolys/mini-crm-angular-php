import { Component } from '@angular/core';
import { RouterLink, RouterLinkActive } from '@angular/router';

import { LucideAngularModule } from 'lucide-angular';


@Component({
  selector: 'app-navbar',
  imports: [RouterLink, RouterLinkActive, LucideAngularModule],
  templateUrl: './navbar.html',
  styleUrl: './navbar.scss',
})
export class NavbarComponent {}

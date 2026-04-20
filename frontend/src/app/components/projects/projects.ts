import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Project, ProjectService } from '../../services/project.service';
import { LucideAngularModule } from 'lucide-angular';

import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-projects',
  standalone: true,
  imports: [CommonModule, LucideAngularModule, FormsModule],
  templateUrl: './projects.html',
  styleUrl: './projects.scss',
})


export class ProjectsComponent implements OnInit {

  projects: Project[] = [];

  constructor(
    private projectService: ProjectService,
    private cdr: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    this.projectService.getAll().subscribe(data => {
      console.log(data);
      this.projects = data;
      this.cdr.detectChanges(); //FORCE LA MISE A JOUR DONNÉE APRES REFRESH
    },
    error => {
      console.error('Error API:', error);
    });
  }

  delete(id: number): void {
    this.projectService.delete(id).subscribe(() => {
      this.projects = this.projects.filter(p => p.id_project !== id);
    })
  }

  //FORMULAIRE ADD CONTACT

  
    showForm = false;
    editingProject: Project | null = null;
    formProject: Project = {
      name: '',
      description: '',
      status: '',
      contact_name: '',
      company_name: '',
    };
  
    openEdit(project: Project) : void {
      this.editingProject = { ...project };
      this.formProject = { ...project };
      this.showForm = true;
    }
  
  
    create(): void {
      this.projectService.create(this.formProject).subscribe({
        next: () => {
          this.projectService.getAll().subscribe(data => {
            this.projects = data;
            this.cdr.detectChanges();
          });
          this.resetForm();
        },
        error: err => console.error('erreur création:', err)
      });
    }
    update(): void {
      if (!this.editingProject?.id_project) return;
      this.projectService.update(this.editingProject.id_project, this.formProject).subscribe({
        next: () => {
        this.projectService.getAll().subscribe(data => {
          this.projects = data;
          this.cdr.detectChanges();
        });
        this.resetForm();
        },
        error: err => console.error('Erreur changement', err)
      });
    }
  
    resetForm(): void {
      this.formProject = { name: '', description: '', contact_name: '', company_name: '', status: ''};
      this.editingProject = null;
      this.showForm = false;
    }
}

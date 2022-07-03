# Introduction

This is a comprehensive employee management & payroll application built with Laravel 9 and Bootstrap 5.

# To-Do

# App

- [ ] App Settings and Controls
  - [ ] Departments
  - [ ] Integrations (i.e. Send CRUD events to external application via Observers)
  - [ ] Closures / Time off (With optional broadcast) (With department only targetting)
- [ ] Navigation search bar (e.g. Employees, Timesheets, ...)

## Employees

- [ ] Department assignments
- [ ] Supervisor tracking (e.g. Joan reports to Barry)
- [ ] Internal comments / Notes
- [ ] Profile picture display
- [ ] PTO cap and limit tracking
- [X] General profile editing
- [X] Employee Communication (e.g. Timesheets, Free form emails, PTO Rejections)
- [X] Time-Off Tracking / Requests

## Payroll / Timesheets

- [X] Editing timesheet options (e.g. Period/Pay type)
- [X] Time card tracking
- [ ] Time calculation by Day (including 1/2 days)
- [ ] Time calculation by Hour
- [ ] Exporting
  - [X] PDF
  - [ ] Email (To Employee / Custom)

## Reports

- [ ] Report Center
- [ ] Statistics/Graphs on pages
  - [ ] Employee Statistics
  - [ ] Overview Statistics

## Other

- [X] Block a user from logging in if their associated employee is not active
- [X] Heavy query caching (i.e. employees, timesheets)
- [X] Fix factories for tables with unique constraints (Timesheets, Timesheet Days)
- [X] Implement lang file for long/duplicated messages
- [X] When employees are terminated, reject all open PTO requests

# Usage

N/A

# Requirements & Dependencies

- PHP 8+
- Laravel 9.X+
- MySQL
- Bootstrap 5.X+

# Previews

TBD

# **This is the API part of BREENGROW application project.**

*Api platform project on domain driven design*.  

This project is still in development.


# Table of contents

[Introduction](#introduction)  
[Application structure](#application-structure)  

- [My approach](#my-approach)  
- [A better approach](#a-better-approach)
  
[Contributiing](#contributing)

## Introduction

This project is a collaborative platform about local commerce.

The purpose of this project is learning the different concepts of DDD:

- Value objects
- Entities
- Domain Model  
- Aggregate root
- Application layer 
- Application services
- Domain layer
- Domain services
- Domain events
- Infrastructure layer  
- Presentation layer  
- Presenter
- View Model  
- Dependency inversion principle
- Factories
- Repositories

For this I used **Symfony** coupled with **Api Platform** package, and so I share here my approach on implementing
Api platform on a *Domain Driven Design* project.

Api platform gives you all the tools necessary to facilitate its use on a Domain Driven Design project application:

- Data Transformers
- Data Providers
- Api resources
- Use of DTO
- etc..

## Application structure

### My approach

```bash
Application
|_  Services
    |_  IdGenerator
    |_  InvoiceService
    |_  OrdersLoader
|_  UseCases
    |_  Consumer
    |_  Deliverer
    |_  Grower
    |_  Invoice
    |_  Order
    Response
    
Domain
|_  Model
|_  Repository
|_  Services
|_  Shared

Infrastucture
|_  Services
|_  Symfony
|_  Templates

Presentation
|_  Api
|_  Web
|_  Command

Shared
|_  Error
|_  Service
|_  SystemClock

```

### A better approach

A better approach is to separate the application into modules(or Bounded context).

```bash
Consumer
|_  Application
|_  Domain
|_  Infrastructure
|_  Presentation
|_  Shared

Deliverer
|_  Application
|_  Domain
|_  Infrastructure
|_  Presentation
|_  Shared

Grower
|_  Application
|_  Domain
|_  Infrastructure
|_  Presentation
|_  Shared

Invoice
|_  Application
|_  Domain
|_  Infrastructure
|_  Presentation
|_  Shared

Order
|_  Application
|_  Domain
|_  Infrastructure
|_  Presentation
|_  Shared

Shared

```

## Contributing

---

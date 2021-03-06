# TimeBreaker Journal

## Overview
This document contains the steps or process I implemented to complete this Assignment.

## Identify Scope and Deliverables
Before doing everything, I made sure that I understand the requirement and the output of the Assignment.  
After identifying the scope, I also checked the Deadline of the project which would help how I would be
breaking my tasks down.

## Set Coding Standard and Design Pattern to be Implemented
After Identifying the scope and deliverables, I also decided which Coding Standard and Design Pattern I'm going to implement for this assignment.  
I've choose to follow PSR-12 Coding Standard and Repository Pattern because I'm more familiar with it.

## Task Breakdown
After I've identified the scope, deliverables, coding standard & design pattern to be used, these are the set of tasks that I was able to come-up with:

| Task | Time Estimation | Notes |
| ------ | ------ | ------ |
| Create Repository | 1 min | |
| Install Lumen Framework | 5 - 10 mins | Serves as a base |
| Create Initial Test Case | 30 mins |  |
| Clean Lumen | 5 - 10 mins |  |
| Create Blank Routes and Controllers | 5 - 10 mins |  |
| Initial Setup Docker | 5 hours |  |
| Create Migration File | 5 mins |  |
| Setup Abstraction Layer and Repository Pattern | 2 hours |  |
| Setup Default Format for all API Response | 1 hour |  |
| Code POST Request (Time Breakdown) | 3-4 hour |  |
| Code GET Request (Time Breakdown) | 1 hour |  |
| Finalize Docker Setup | 1-2 hours |  |
| Setup CI/CD and Apply Fixes | 4-5 hours |  |
| Create README Documention | 1 hour |  |
| Create JOURNAL | 1 hour |  |
|  | 23.1 hours |  |

## Improvements

#### Project Structure
Since I used Lumen Framework for this assignment, there was only few example files that are included, which are now deleted, and don't need much of cleaning.

#### Portability
To achieved this improvement, I used Docker and Docker-Compose to orchestrate the necessary containers that are needed to run TimeBreaker App.  

I also ensure that the containers are not to big which will take time installing, i. e. using a whole OS for a single container. 
Other developers would only need to download **Docker with Docker Compose**, clone the repository, and then run the **setup.sh** script I created  
which automatically run the necessary commands for any developer.

#### Documentation
I updated the README file and ensure that the requirement for this improvement has been met. The readme file contains the purpose of the Assignment,  
requirements, Open-source projects/packages and Cloud Services used, and on how to install and run it.

#### 12-factor App
I used GitHub, a Design Pattern, optimized Docker Containers, and implemented CI/CD to follow most of principles under 12-factor App.

#### Deployment
I integrated AWS CodePipeline and CodeDeploy to automatically build and deploy the changes after merging the updates on **main** branch of this Repository.

#### Journal
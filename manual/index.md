---
currentMenu: manual-home
---

# Snipe-IT User's Manual

(This manual is a work in progress - please check back often.)

## Basic concepts

### Checkin/Checkout

Checking in and checking out are two primary concepts behind Snipe-IT. When you checkout an asset, license or accessory, you’re marking them as being in the possession of someone else. This means that they cannot subsequently be checked out to another person until they are checked back in. This prevents “double-booking” assets, where one asset has been promised to or assigned to multiple people.

When an employee leaves your company, or if an asset, license or accessory is not functioning properly, you would check it back in. Checking it back in indicates that it’s back in your possession, or potentially out for repair. It’s up to you to decide what status to assign it, based on the condition of the asset.

-----

### Status Labels

Status labels are used to describe the state of the asset. You can add as many status labels as you’d like. Each status label will have one of four characteristics that describe the state of assets with that status label:

Undeployable: these assets cannot be assigned to anyone.

Deployable: these assets can be assigned to people

Archived: these assets cannot be assigned to people, and will only show up in the Archived view

Pending – these assets can not yet be assigned to anyone.

Use status labels however you see fit. You can just keep the starter labels we set up for you, or you can flesh out a detailed set of statuses that will make sure your team always knows exactly what’s going on with each asset.

If you set up your status labels well, they can be enormously useful. A status label that is a pending label named “Awaiting Re-Imaging” tells your team that this item can’t be deployed because it’s still in the re-imaging stage and isn’t ready yet. Once it’s ready, your team can update the status to “Ready to Deploy”, and then it’s added to the pool of available deployable resources.

-----

## Getting Started

### Setting up Locations

If you have a fresh install of Snipe-IT, it can be confusing on where to get started. The best place to start is to set up your locations. Even if you only have one location, you’ll want to get that set up first, since users, assets and many other things within the Snipe-IT system rely on it.

From here you can start adding users if you want, or move on to adding asset models and assets.

### Asset Categories

Asset categories are used by both assets and accessories. Categories describe the general type of asset or accessory, such as “wireless keyboards”, “laptops”, and so on. Categories are important because they contain attributes that are inherited by both the assets and accessories that long to them, such as whether to require the user to click on a link to show that they have received the asset or accessory, and whether or not the user should be emailed a EULA.

Every asset and accessory needs to belong to a category, so you’ll need to set these up before adding assets.

### Asset Models

Every asset needs an asset model, so setting these up next will help you start adding assets. Asset models can be things like the make and model of a laptop or desktop machine (Apple 13″ Retina, for example). When you create new assets, you’ll select whichever asset model makes sense.

Asset models are important because they carry certain attributes which are inherited by the assets you, such as depreciation type, end of life, and whether or not to show MAC address fields on the asset.

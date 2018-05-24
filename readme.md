# Own Assets

This module enables automatic assets publishing for non-versioned data objects. It uses `$owns` array to determine what assets should be published after data object is saved.

### Configuration

```yml
---
Name: own-assets
---
SilverStripe\ORM\DataObject:
  extensions:
    - bratiask\OwnAssets\Extension\OwnAssetsExtension
```
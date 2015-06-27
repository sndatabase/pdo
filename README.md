# SN Databse : PDO Plugin

The SN Database api aims to provide a unified interface for database access without having to worry about the various PHP extension avilable for each database type.

This particular package brings the PDO Plugin of the api : some driver will use this for easier interaction with PDO

# Download

This package is a requirement for actual drivers, and will be downloaded automatically by Composer upon requiring a driver.

```
"sndb/core": "~1.0"
```

# Usage

Cannot be used on its own, you need to download a driver that uses it, or create your own.

To generate the documentation, use the apigen.neon file to generate it in a "docs" folder

```
> apigen generate
```

# Testing

Coming soon, in /tests subfolder...

# Contributors

Samy Naamani <samy@namani.net>

# License

MIT
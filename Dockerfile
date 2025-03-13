# Use the official PostgreSQL image as a base
FROM postgres:latest

# Set environment variables for PostgreSQL
ENV POSTGRES_DB=expression
ENV POSTGRES_USER=rounakadmin
ENV POSTGRES_PASSWORD=rounakadmin

# Copy the SQL dump file into the PostgreSQL initialization directory
COPY dbfile.sql /docker-entrypoint-initdb.d/

# Expose the default PostgreSQL port
EXPOSE 5432

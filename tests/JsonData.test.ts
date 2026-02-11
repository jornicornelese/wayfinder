import { existsSync, readFileSync } from "fs";
import { join } from "path";
import { describe, expect, test } from "vitest";

describe("JsonData", () => {
    const typesPath = join(
        __dirname,
        "../workbench/resources/js/wayfinder/types.d.ts"
    );

    test("types.d.ts contains ApiController namespace", () => {
        const content = readFileSync(typesPath, "utf-8");
        expect(content).toContain("export namespace ApiController");
    });

    test.skip("ApiController types directory exists", () => {
        const apiTypesPath = join(
            __dirname,
            "../workbench/resources/js/wayfinder/types/App/Http/Controllers/ApiController"
        );
        expect(existsSync(apiTypesPath)).toBe(true);
    });

    test("has Status method namespace", () => {
        const content = readFileSync(typesPath, "utf-8");
        expect(content).toContain("export namespace Status");
    });

    test("has Users method namespace", () => {
        const content = readFileSync(typesPath, "utf-8");
        expect(content).toContain("export namespace Users");
    });
});

describe("Resource Collection Types", () => {
    const typesPath = join(
        __dirname,
        "../workbench/resources/js/wayfinder/types.d.ts"
    );

    test("has Collection method namespace in ResourceController", () => {
        const content = readFileSync(typesPath, "utf-8");
        expect(content).toContain("export namespace Collection");
    });

    test("collection response type is an array of the resource type", () => {
        const content = readFileSync(typesPath, "utf-8");
        expect(content).toMatch(/export namespace Collection\s*\{[^}]*data:\s*App\.Http\.Resources\.UserResource\[\]/);
    });

    test("has Paginated method namespace in ResourceController", () => {
        const content = readFileSync(typesPath, "utf-8");
        expect(content).toContain("export namespace Paginated");
    });

    test("paginated response type is an array of the resource type", () => {
        const content = readFileSync(typesPath, "utf-8");
        expect(content).toMatch(/export namespace Paginated\s*\{[^}]*data:\s*App\.Http\.Resources\.UserResource\[\]/);
    });

    test("paginated response type includes pagination links", () => {
        const content = readFileSync(typesPath, "utf-8");
        // Extract the Paginated Response type
        const paginatedMatch = content.match(/export namespace Paginated\s*\{[^}]*export type Response = ([^\n]+)/);
        expect(paginatedMatch).not.toBeNull();
        const responseType = paginatedMatch![1];
        expect(responseType).toContain("links:");
        expect(responseType).toContain("first: string | null");
        expect(responseType).toContain("next: string | null");
    });

    test("paginated response type includes pagination meta", () => {
        const content = readFileSync(typesPath, "utf-8");
        const paginatedMatch = content.match(/export namespace Paginated\s*\{[^}]*export type Response = ([^\n]+)/);
        expect(paginatedMatch).not.toBeNull();
        const responseType = paginatedMatch![1];
        expect(responseType).toContain("meta:");
        expect(responseType).toContain("current_page: number");
        expect(responseType).toContain("per_page: number");
        expect(responseType).toContain("total: number");
    });

    test("non-paginated collection response does not include pagination meta", () => {
        const content = readFileSync(typesPath, "utf-8");
        const collectionMatch = content.match(/export namespace Collection\s*\{[^}]*export type Response = ([^\n]+)/);
        expect(collectionMatch).not.toBeNull();
        const responseType = collectionMatch![1];
        expect(responseType).not.toContain("meta:");
        expect(responseType).not.toContain("current_page");
    });
});

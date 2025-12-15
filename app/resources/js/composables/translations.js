import { usePage } from '@inertiajs/react';

export function __(value) {
  const array = usePage().props.translations;
  return array[value] != null ? array[value] : value;
}